<?php

use app\controllers\QuizController;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Quiz */
/* @var $dropDownList QuizController */

$this->title = 'Create Quiz';
$this->params['breadcrumbs'][] = ['label' => 'Quizzes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quiz-create">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <?php echo $this->render('_form',
        [
            'model' => $model,
            'dropDownList' => $dropDownList,
        ]);
    ?>

</div>
