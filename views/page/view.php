<?php

use yii\helpers\Html;
use yii\data\ArrayDataProvider;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model app\models\Page */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="page-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>By <?= $model->user->username ?> | <?= $model->formattedPublishedDate() ?></p>
    <div><?= $model->content ?></div>
</div>

<div class="comments">
    <h3>Comments</h3>
    <?php 
    $comments = $model->comments;
    if (count($comments) >= 1) {
        $data = new ArrayDataProvider([
            'allModels' => $comments,
        ]);
        echo ListView::widget([
            'dataProvider' => $data,
            'itemView' => '_comment',
        ]);
    } else {
        echo '<b>Be the first to comment on this page!</b>';
    }
    ?>

</div>

<div>
    <h3>Leave a Comment</h3>
    <?php if (Yii::$app->session->hasFlash('commentSubmitted')): ?>
        <p class="alert alert-success">
            <?php echo Yii::$app->session->getFlash('commentSubmitted'); ?>
        </p>
    <?php else: ?>
        <?php echo $this->render('@app/views/comment/_form', [
            'model'=>$comment,
        ]); ?>
    <?php endif; ?>
</div>
