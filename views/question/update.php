<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Question */

$this->title = 'Update Question : ' . $model->name;
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="question-update">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <?php echo $this->render('_form',
        [
            'model' => $model,
        ]);
    ?>

</div>
