<?php


namespace app\controllers;

use Yii;
use app\models\QuizSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class StartController extends Controller
{

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
                'only' => ['index'],
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

        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('error', 'Please Login');
            return $this->redirect('/site/login');
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}