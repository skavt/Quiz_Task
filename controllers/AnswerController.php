<?php

namespace app\controllers;

use app\models\Question;
use Yii;
use app\models\Answer;
use app\models\AnswerSearch;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AnswerController implements the CRUD actions for Answer model.
 */
class AnswerController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'update', 'delete', 'create'],
                'rules' => [
                    [
                        'allow' => false,
                        'roles' => ['?'],
                        'denyCallback' => function () {
                            Yii::$app->session->setFlash('error', 'Please Login');
                            return Yii::$app->controller->redirect('/site/login');
                        }
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all Answer models.
     * @param $id
     * @return mixed
     */
    public function actionIndex($id)
    {
        $searchModel = new AnswerSearch();
        $questionModel = Question::findOne($id);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'questionModel' => $questionModel,
        ]);

    }

    /**
     * Displays a single Answer model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Answer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param $id
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new Answer();
        $questionModel = Question::findOne($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->question_id = $id;
            $correctAnsCount = Answer::find()->where(['question_id' => $id, 'is_correct' => true])->count();
            $incorrectAnsCount = Answer::find()->where(['question_id' => $id, 'is_correct' => false])->count();
            $count = Answer::find()->where(['question_id' => $id])->count();

            if ($count >= $questionModel->max_ans) {
                Yii::$app->session->setFlash('error', 'You can\'t create new answer');
                return $this->render('create', [
                    'model' => $model,
                    'questionModel' => $questionModel,
                ]);
            }

            if ($correctAnsCount == 1 && $model->is_correct == 1) {
                Yii::$app->session->setFlash('error', 'You have already chosen correct answer');
                return $this->render('create', [
                    'model' => $model,
                    'questionModel' => $questionModel,
                ]);
            }  else if($incorrectAnsCount == $questionModel->max_ans-1 && $model->is_correct == 0) {
                Yii::$app->session->setFlash('error', 'You can\'t choose another incorrect answer');
                return $this->render('create', [
                    'model' => $model,
                    'questionModel' => $questionModel,
                ]);
            }

            if ($model->save()) {
                return $this->redirect(['index', 'id' => $questionModel->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'questionModel' => $questionModel,
        ]);
    }

    /**
     * Updates an existing Answer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Answer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $questionId = $model->question_id;
        $this->findModel($id)->delete();

        return $this->redirect(['answer/index', 'id' => $questionId]);
    }

    /**
     * Finds the Answer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Answer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Answer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
