<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/19/2018
 * Time: 4:03 PM
 */

use yii\helpers\Html;
use common\components\Helper;
use common\components\Translate;
use yii\helpers\StringHelper;
use kartik\rating\StarRating;

$this->title = Translate::text($types->getLangHasTypes(), 'meta_title');
$this->registerMetaTag(['name' => 'keywords', 'content' => Translate::text($types->getLangHasTypes(), 'meta_keys')]);
$this->registerMetaTag(['name' => 'description', 'content' => Translate::text($types->getLangHasTypes(), 'meta_description')]);

$this->params['breadcrumbs'][] = Translate::text($types->getLangHasTypes(), 'name');
?>
<span style="display: none;" itemprop="description"><?= $types->description_hide?></span>
<span style="display: none;" itemprop="keywords"><?= $types->keys_hide?></span>

<div class="container">
    <h1><?= Translate::text($types->getLangHasTypes(), 'name')?></h1>
    <div class="row">
        <?foreach ($hospitals as $hospital):?>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="hospital row">
                    <div class="col-lg-5">
                        <a style="background-image: url(<?= "/uploads/hospitals/".$hospital->image?>)" class="img-hospital" href="<?= Helper::lang($hospital->type->alias.'/'.$hospital->alias)?>">
                            <? Html::img("/uploads/hospitals/".$hospital->image, ['class' => 'img-hospital', 'alt' => 'hospital-img'])?>
                        </a>
                    </div>
                    <div class="col-lg-7">
                        <div class="name">
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <a href="<?= Helper::lang($hospital->type->alias.'/'.$hospital->alias)?>">
                                        <h6><?= Translate::text($hospital->getLangHasHospitals(), 'name'); ?></h6>
                                    </a>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <div class="sale">
                                        <?if($hospital->sale):?>
                                            <?= $hospital->sale?>
                                        <?endif;?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-5 col-md-5 col-sm-5">
                                    <?= StarRating::widget([
                                        'name' => 'url-'.$hospital->id,
                                        'value' => Helper::ratingHospital($hospital->id),
                                        'pluginOptions' => [
                                            'disabled'=> true,
                                            'showCaption' => false,
                                            'showClear'=>false,
                                            'size'=>'xs'
                                        ]
                                    ]);?>
                                </div>
                                <div class="col-lg-7 col-md-7 col-sm-7">
                                    <a class="link"><?= Helper::ratingHospitalCount($hospital->id)?> <?= Yii::t('frontend', 'reviews')?></a>
                                </div>
                                <div class="col-lg-12">
                                    <button onclick="registerHospital(<?= (int) $hospital->id ?>)" type="button" class="btn fix-button" data-toggle="modal" data-target="#exampleModal">
                                        <?= Yii::t('frontend', 'Register and get a discount')?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <p class="sector">
                            <a href="<?= Helper::lang($hospital->type->alias.'/'.$hospital->alias)?>">
                                <?= StringHelper::truncate(strip_tags(Translate::text($hospital->getLangHasHospitals(), 'tiny_text')),140,'...');?>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        <?endforeach;?>

    </div>
</div>

