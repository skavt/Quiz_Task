<?php

namespace app\controllers;

use app\models\Answer;
use app\models\Question;
use app\models\QuestionSearch;
use app\models\Result;
use app\models\ResultSearch;
use Yii;
use app\models\Quiz;
use app\models\QuizSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

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
        $searchModel = new QuestionSearch();
        $quizModel = Quiz::findOne($id);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'quizModel' => $quizModel,
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
        $dropDownList = $model->dropDownList();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        }
        return $this->render('create', [
            'model' => $model,
            'dropDownList' => $dropDownList,
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
        $dropDownList = $model->dropDownList();


        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);

        }

        return $this->render('update', [
            'model' => $model,
            'dropDownList' => $dropDownList,
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
        $result = new Result();
        $quizModel = $this->findModel($id);
        $questionModel = Question::find()->where(['quiz_id' => $id])->all();
        $countQuestion = Question::find()->where(['quiz_id' => $id])->count();

        foreach ($questionModel as $question) {
            $countAnswer = Answer::find()->where(['question_id' => $question->id])->count();
//            var_dump($countAnswer);
            if ($countAnswer == 0 || $countAnswer == 1) {
                Yii::$app->session->setFlash('error', 'Please add Answers and you can Start quiz');
                return $this->render('_error');
            }
        }

        if ($countQuestion < $quizModel->min_correct_ans) {
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
            $result->question_count = $countQuestion;
            $result->min_correct_ans = $quizModel->min_correct_ans;
            $result->created_at = time();
            $month = strtotime(" + $quizModel->certification_valid months", $result->created_at);
            $result->certification_valid = $month;

            if (!$result->save()) {
                Yii::$app->session->setFlash('error', 'Your result is not save. Please try again');
                return $this->render('_error');
            }

            return $this->render('outcome', [
                'failed' => $failed,
                'passed' => $passed,
                'countQuestion' => $countQuestion,
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
        $searchModel = new ResultSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('result', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
