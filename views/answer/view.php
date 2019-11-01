<?php

use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Answer */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Answers', 'url' => ['answer/index/', 'id' => $model->question_id]];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>

<div class="answer-view">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <?php echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?php echo Html::a('Delete', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' =>
            [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
    ]) ?>
    <p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' =>
            [
                'is_correct',
                'name',
                'created_at:datetime',
                'updated_at:datetime',
                [
                    'attribute' => 'created_by',
                    'value' => function ($model) {
                        return $model->createdBy->username;
                    }
                ],
                [
                    'attribute' => 'updated_by',
                    'value' => function ($model) {
                        return $model->updatedBy->username;
                    }
                ],
            ],
    ]) ?>

</div>
