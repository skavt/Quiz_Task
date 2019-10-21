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
//        var_dump($dataProvider); exit;
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site/login');
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}