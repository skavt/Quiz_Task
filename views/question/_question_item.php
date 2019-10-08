<?php
/** @var $model \app\models\Question */
?>

<div>
    <a href="<?php echo \yii\helpers\Url::to(['/answer/index', 'id' => $model->id]) ?>">
        <h3><?php echo \yii\helpers\Html::encode($model->name) ?></h3>
    </a>
    <p calss="text-muted">
        <small><?php echo \yii\helpers\Html::encode($model->hint) ?></small>
    <hr>
</div>
