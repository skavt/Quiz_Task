<?php

use app\controllers\AnswerController;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Answer */
/* @var $questionModel AnswerController */

$this->title = 'Update Answer: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="answer-update">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <?php echo $this->render('_form',
        [
            'model' => $model,
        ]);
    ?>

</div>
