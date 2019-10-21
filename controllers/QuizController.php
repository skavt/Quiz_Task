<?php

namespace app\controllers;

use app\models\Answer;
use app\models\Question;
use app\models\Result;
use app\models\ResultSearch;
use app\models\User;
use Yii;
use app\models\Quiz;
use app\models\QuizSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * QuizController implements the CRUD actions for Quiz model.
 */
class QuizController extends Controller
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
     * Lists all Quiz models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site/login');
        }
        $searchModel = new QuizSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Quiz model.
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
     * Creates a new Quiz model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Quiz();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Quiz model.
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
     * Deletes an existing Quiz model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Quiz model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Quiz the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Quiz::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionStart($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site/login');
        }
        $result = new Result();
        $quizModel = $this->findModel($id);
        $questionModel = Question::find()->where(['quiz_id' => $id])->all();

        if (Yii::$app->request->post()) {
            $response = Yii::$app->request->post();
            $answerIndex = 0;
            $correctAnswer = 0;
            $array = [];


            foreach ($response as $text => $answerId) {
                $select = substr($text, 0, 9);
                if ($select == 'selected_') {
                    $array[$answerIndex] = $answerId;
                    $answerIndex++;
                }

            }
            foreach ($array as $arr) {
                $answer = Answer::findOne($arr);
                if ($answer->is_correct == 1) {
                    $correctAnswer++;
                }

            }
            if ($correctAnswer < $quizModel->min_correct_ans) {
                $failed = ' ';
                $passed = '';
            } else {
                $passed = ' ';
                $failed = '';
            }
            $count = Question::find()->where(['quiz_id' => $id])->count();
            $result->correct_ans = $correctAnswer;
            $result->quiz_id = $quizModel->id;
            $result->quiz_name = $quizModel->subject;
            $result->question_count = $count;
            $result->min_correct_ans = $quizModel->min_correct_ans;
            $result->created_at = time();
            if (!$result->save()) {
                var_dump($result->errors);
                exit;
            }
            return $this->render('outcome', [
                'failed' => $failed,
                'passed' => $passed,
                'count' => $count,
                'correctAnswer' => $correctAnswer,
                'quizModel' => $quizModel,
            ]);
        }


        return $this->render('start', [
            'quizModel' => $quizModel,
            'questionModel' => $questionModel,

        ]);
    }

    public function actionResult()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site/login');
        }
        $searchModel = new ResultSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $result = Result::find()->all();
//        var_dump($result); exit();

        return $this->render('result', [
            'result' => $result,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
