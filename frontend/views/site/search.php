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

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
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
                                    <?= \yii2mod\rating\StarRating::widget([
                                        'name' => 'input_name',
                                        'value' => 0,
                                        'clientOptions' => [
                                            // Your client options
                                        ],
                                    ]);?>
                                </div>
                                <div class="col-lg-7 col-md-7 col-sm-7">
                                    <a class="link" href="#">0 <?= Yii::t('frontend', 'reviews')?></a>
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

        <?foreach ($doctors as $doctor):?>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="doctor row">
                    <div class="col-lg-5">
                        <a style="background-image: url(<?= "/uploads/doctors/".$doctor->image?>)" class="img-doctor" href="<?= Helper::lang('doctor/'.$doctor->alias)?>">
                            <? Html::img("/uploads/doctors/".$doctor->image, ['class' => 'img-doctor', 'alt' => 'doctor-img'])?>
                        </a>
                    </div>
                    <div class="col-lg-7">
                        <div class="name">
                            <a href="<?= Helper::lang('doctor/'.$doctor->alias)?>">
                                <h6><?= Translate::text($doctor->getLangHasDoctors(), 'full_name'); ?></h6>
                                <p><?= Translate::text($doctor->getLangHasDoctors(), 'doctor_info'); ?></p>
                            </a>
                            <div class="row">
                                <div class="col-lg-5">
                                    <?= \yii2mod\rating\StarRating::widget([
                                        'name' => 'input_name',
                                        'value' => 0,
                                        'clientOptions' => [
                                            // Your client options
                                        ],
                                    ]);?>
                                </div>
                                <div class="col-lg-7">
                                    <a class="link" href="#">0 <?= Yii::t('frontend', 'reviews')?></a>
                                </div>
                                <div class="col-lg-12">
                                    <button onclick="registerDoctor(<?= (int) $doctor->id ?>)" type="button" class="btn fix-button" data-toggle="modal" data-target="#exampleModal">
                                        <?= Yii::t('frontend', 'Register and get a discount')?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <p class="sector">
                            <a href="<?= Helper::lang('doctor/'.$doctor->alias)?>">
                                <?= StringHelper::truncate(strip_tags(Translate::text($doctor->getLangHasDoctors(), 'tiny_text')),140,'...');?>

                            </a>
                        </p>
                    </div>
                </div>
            </div>
        <?endforeach;?>
        <?if(empty($hospitals) && empty($doctors)):?>
            <div class="search_content">
                <h2 class="no_rezult"><?= Yii::t('frontend', 'Nothing found')?></h2>
                <div class="not_search_img">
                    <img src="/images/search-not-found.jpg" alt="" class="no_search">
                </div>

            </div>
        <?endif;?>
    </div>
</div>

