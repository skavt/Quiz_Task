<?php

use app\controllers\QuizController;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Quiz */
/* @var $dropDownList QuizController */

$this->title = 'Update Quiz: ' . $model->subject;
$this->params['breadcrumbs'][] = ['label' => 'Quizzes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->subject, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="quiz-update">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <?php echo $this->render('_form',
        [
            'model' => $model,
        ]);
    ?>


</div>
