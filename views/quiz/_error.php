<?php
$this->params['breadcrumbs'][] = ['label' => 'Quiz', 'url' => ['quiz/index/']];
?>
<div class="question-index">

    <?php if (Yii::$app->session->hasFlash('error')) : ?>
            <?php Yii::$app->session->getFlash('error'); ?>
    <?php endif; ?>

</div>
