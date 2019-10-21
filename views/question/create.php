<?php

use app\models\Quiz;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $newModel Quiz */
/* @var $model app\models\Question */

$this->title = 'Create question for : ' . $newModel->subject;
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
