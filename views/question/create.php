<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $newModel \app\models\Quiz*/
/* @var $model app\models\Question */

$this->title = 'Create question for : ' . $newModel->subject . ' quiz';
//$this->params['breadcrumbs'][] = ['label' => 'Questions', 'url' => ['question/index/', 'id'=>$_GET['id']]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
