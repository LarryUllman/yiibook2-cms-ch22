<?php

use yii\helpers\Html;

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
