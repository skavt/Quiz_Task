<?php

namespace app\controllers;

use app\models\Answer;
use app\models\AnswerSearch;
use app\models\Quiz;
use Yii;
use app\models\Question;
use app\models\QuestionSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * QuestionController implements the CRUD actions for Question model.
 */
class QuestionController extends Controller
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
                'only' => ['index', 'view', 'delete', 'create', 'update',],
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
     * Lists all Question models.
     * @param $id
     * @return mixed
     */
    public function actionIndex($id)
    {
        $searchModel = new QuestionSearch();
        $quizModel = Quiz::findOne($id);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'quizModel' => $quizModel,
        ]);
    }

    /**
     * Displays a single Question model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $searchModel = new AnswerSearch();
        $questionModel = Question::findOne($id);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'questionModel' => $questionModel,
        ]);
    }

    /**
     * Creates a new Question model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionCreate($id)
    {
        $model = new Question();
        $quizModel = Quiz::findOne($id);

        $count = Question::find()
            ->where(['quiz_id' => $id])
            ->count();

        if ($count >= $quizModel->max_questions) {
            Yii::$app->session
                ->setFlash('error', 'You can\'t create new question');

            return $this->render('/quiz/_error');
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->quiz_id = $id;

            if ($model->save()) {

                return $this->redirect([
                    'index', 'id' => $quizModel->id
                ]);

            }
        }

        return $this->render('create', [
            'model' => $model,
            'quizModel' => $quizModel,
        ]);
    }

    /**
     * Updates an existing Question model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect([
                'view', 'id' => $model->id
            ]);

        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Question model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $quizId = $model->quiz_id;
        $this->findModel($id)->delete();

        return $this->redirect([
            'question/index', 'id' => $quizId
        ]);
    }

    /**
     * Finds the Question model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Question the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Question::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
