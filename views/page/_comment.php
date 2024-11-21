<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<hr> 
<div class="comment">
    <p><?= HtmlPurifier::process($model->comment) ?></p>
    <p><?= HtmlPurifier::process($model->username) ?></p>
</div>
