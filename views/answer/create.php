<?php

use app\controllers\AnswerController;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Answer */
/* @var $questionModel AnswerController */


$this->title = 'Create answer for: ' . $questionModel->name;
$this->params['breadcrumbs'][] = ['label' => 'Answer', 'url' => ['answer/index/', 'id' => $_GET['id']]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="answer-create">

    <?php if (Yii::$app->session->hasFlash('error')) : ?>
        <?php Yii::$app->session->getFlash('error'); ?>
    <?php endif; ?>

    <h1><?php echo Html::encode($this->title) ?></h1>

    <?php echo $this->render('_form',
        [
            'model' => $model,
        ]);
    ?>

</div>
