<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Question */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Questions', 'url' => ['question/index', 'id' => $model->quiz_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="question-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    <p calss="text-muted">
        <small>
            Created At: <?php echo Yii::$app->formatter->asRelativeTime($model->created_at) ?>
            <br>
            Updated At: <?php echo Yii::$app->formatter->asRelativeTime($model->updated_at) ?>
        </small>
    </p>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
//            'quiz_id',
            'name',
            'hint',
            'max_ans',
//            'created_at',
//            'updated_at',
        ],
    ]) ?>

</div>
