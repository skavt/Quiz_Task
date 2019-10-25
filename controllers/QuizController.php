<?php

namespace app\controllers;

use app\models\Answer;
use app\models\AnswerSearch;
use app\models\Question;
use app\models\QuestionSearch;
use app\models\Result;
use app\models\ResultSearch;
use Yii;
use app\models\Quiz;
use app\models\QuizSearch;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
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
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'update', 'delete', 'result', 'start', 'create'],
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
     * Lists all Quiz models.
     * @return mixed
     */
    public function actionIndex()
    {
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

        if ($model->load(Yii::$app->request->post()) && $model->min_correct_ans > $model->max_questions) {
            Yii::$app->session->setFlash('error', 'You can\'t create quiz. Min correct answer num is more than Max question num');
            return $this->render('_error');
        }
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
//        $searchModel = new QuestionSearch();
        $result = new Result();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
        $quizModel = $this->findModel($id);
        $questionModel = Question::find()->where(['quiz_id' => $id])->all();
        $count = Question::find()->where(['quiz_id' => $id])->count();

        if ($count < $quizModel->min_correct_ans) {
            Yii::$app->session->setFlash('error', 'Please add more Questions and you can Start quiz');
            return $this->render('_error');
        }
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

            $result->correct_ans = $correctAnswer;
            $result->quiz_name = $quizModel->subject;
            $result->question_count = $count;
            $result->min_correct_ans = $quizModel->min_correct_ans;
            $result->created_at = time();
            $month = strtotime(" + $quizModel->certification_valid months", $result->created_at);
            $result->certification_valid = $month;;

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
        $query = Question::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 1,
            ],
        ]);

        return $this->render('start', [
            'quizModel' => $quizModel,
            'questionModel' => $questionModel,
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,

        ]);
    }

    public function actionResult()
    {
        $searchModel = new ResultSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('result', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
