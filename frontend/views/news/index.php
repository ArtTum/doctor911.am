<?php
/**
 * Created by PhpStorm.
 * User: artur999
 * Date: 10/16/2018
 * Time: 2:06 PM
 */

use yii\helpers\Html;
use common\components\Helper;
use common\components\Translate;
use yii\helpers\StringHelper;

$this->title = Yii::t('frontend', Yii::t('frontend', 'News'));
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <h1> <?= $this->title?></h1>
    <div class="row">
        <div class="all-blogs">
            <?foreach ($blogs as $blog):?>
                <div class="col-md-6 col-lg-6">
                    <div class="media">
                        <a class="pull-left" href="<?= Helper::lang('single-news/'.$blog->alias)?>">
                            <img height="170px" src="/uploads/news/254-223/<?= $blog->image?>" alt="...">
                        </a>

                        <div class="media-body">
                            <a class="pull-left" href="<?= Helper::lang('single-news/'.$blog->alias)?>">
                                <h4 class="media-heading"><strong><?= Translate::text($blog->getLangHasNews(), 'name');?></strong></h4>
                            </a>
                            <p class="author">
                                <br>
                                <?= StringHelper::truncate(strip_tags(Translate::text($blog->getLangHasNews(), 'description')),200,'...');?>
                            </p>
                        </div>
                    </div>
                </div>
            <?endforeach;?>
        </div>
    </div>
    <br>   <br>
</div>