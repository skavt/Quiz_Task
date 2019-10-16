<?php

use app\models\Question;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Answer */
/* @var $newModel Question */


$this->title = 'Create answer for: ' . $newModel->name . ' question';
$this->params['breadcrumbs'][] = ['label' => 'Answer', 'url' => ['answer/index/', 'id' => $_GET['id']]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="answer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
