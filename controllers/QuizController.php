<?php

namespace app\controllers;

use app\models\Answer;
use app\models\Checked;
use app\models\Progress;
use app\models\Question;
use app\models\QuestionSearch;
use app\models\Result;
use app\models\ResultSearch;
use Yii;
use app\models\Quiz;
use app\models\QuizSearch;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\Json;
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

    public function actionProgress()
    {
        $progressModel = new Progress();

        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {

            $data = Yii::$app->request->post();

            $progressModel->deleteAll(['question_id' => $data['question_id']]);

            $progressModel->insertData();

        }

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return Json::encode($progressModel->progressData());
        }
    }

    public function actionOutcome($id)
    {
        $progressModel = new Progress();
        $quizModel = $this->findModel($id);

        $progress = $progressModel->outcomeData();
        $bla = $progressModel->allAnswerChecked();

        $correctAnswer = $progress['countCorrectAnswer'];
        $countQuestion = $progress['countQuestion'];

        if ($bla['success'] == false) {
            Yii::$app->session->setFlash('error', $bla['message']);
            return $this->redirect(['start', 'id' => $id]);
        }

        if ($correctAnswer < $quizModel->min_correct_ans) {
            $failed = ' ';
            $passed = '';
        } else {
            $failed = '';
            $passed = ' ';
        }

        $quizModel->insertResultData();

        $progressModel->deleteAll(['quiz_id' => $id]);

        return $this->render('outcome', [
            'correctAnswer' => $correctAnswer,
            'countQuestion' => $countQuestion,
            'quizModel' => $quizModel,
            'failed' => $failed,
            'passed' => $passed,
        ]);

    }

    public function actionStart($id)
    {
        $quizModel = $this->findModel($id);
        $questionModel = Question::find()
            ->where(['quiz_id' => $id])
            ->all();

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return Json::encode($quizModel->questionsWithAnswers());
        }

        $questionValidator = $quizModel->startQuizQuestionValidation();

        if ($questionValidator == true) {
            Yii::$app->session
                ->setFlash('error', 'Please add more Questions and you can Start quiz');

            return $this->render('_error');
        }

        $answerValidator = $quizModel->startQuizAnswerValidation();

        if ($answerValidator == true) {
            $answerValidator = substr($answerValidator, 1);
            Yii::$app->session
                ->setFlash('error', 'Please add Valid Answers for ( Quiz : "' . $quizModel->subject .
                    '", Question : "' . $answerValidator . '" ) and you can Start quiz');

            return $this->render('_error');
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
