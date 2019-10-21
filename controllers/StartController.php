<?php


namespace app\controllers;

use Yii;
use app\models\QuizSearch;
use yii\web\Controller;

class StartController extends Controller
{
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