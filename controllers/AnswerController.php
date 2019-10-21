<?php

namespace app\controllers;

use app\models\Question;
use Yii;
use app\models\Answer;
use app\models\AnswerSearch;
use yii\db\StaleObjectException;
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
        ];
    }

    /**
     * Lists all Answer models.
     * @param $id
     * @return mixed
     */
    public function actionIndex($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site/login');
        }
        $searchModel = new AnswerSearch();
        $newModel = Question::findOne($id);
        $questionId = $newModel->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'newModel' => $newModel,
            'questionId' => $questionId,
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
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site/login');
        }
        $model = new Answer();
        $newModel = Question::findOne($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->question_id = $id;
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        $count = Answer::find()->where(['question_id' => $id])->count();
        if($count >= $newModel->max_ans){
            return $this->render('_error', [
                'model' => $model,
                'newModel' => $newModel,
            ]);
        }

        return $this->render('create', [
            'model' => $model,
            'newModel' => $newModel,
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

        return $this->redirect(['answer/index', 'id'=> $questionId]);
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
