<?php

/* @var $this yii\web\View */

use common\components\Translate;
use yii\helpers\Html;

$this->title = Translate::text($page->getLangHasPages(), 'name');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="site-about">
        <h1><?= Html::encode($this->title) ?></h1>
        <hr>
        <div>
            <?= Translate::text($page->getLangHasPages(), 'description')?>
        </div>

    </div>
</div>