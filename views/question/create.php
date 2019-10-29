<?php

use app\controllers\QuestionController;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $quizModel QuestionController */
/* @var $model app\models\Question */

$this->title = 'Create question for : ' . $quizModel->subject;
$this->params['breadcrumbs'][] = ['label' => 'Questions', 'url' => ['question/index/', 'id' => $_GET['id']]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="question-create">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <?php echo $this->render('_form',
        [
            'model' => $model,
        ]);
    ?>

</div>
