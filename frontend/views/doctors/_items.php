<?php
/**
 * Created by PhpStorm.
 * User: artur999
 * Date: 10/4/2018
 * Time: 2:33 PM
 */
use yii\helpers\Html;
use common\components\Helper;
use common\components\Translate;
use yii\helpers\StringHelper;
use kartik\rating\StarRating;

?>

<?foreach ($doctors as $doctor):?>
<?php if($doctor->status == 1):?>
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
                    <?if($doctor->plastic_surgeon ):?>
                        <a class="link" href="<?= Helper::lang('gallery/'.$doctor->alias)?>"><?= Yii::t('frontend', 'Photos')?></a>
                    <?endif;?>
                    <div class="row">

                        <div class="col-lg-5">
                            <div class="rating-container rating-xs rating-animate rating-disabled">
                                <div class="rating-stars">
                                    <span class="empty-stars">
                                        <span class="star">
                                            <i class="glyphicon glyphicon-star-empty"></i>
                                        </span>
                                        <span class="star">
                                            <i class="glyphicon glyphicon-star-empty"></i>
                                        </span>
                                        <span  class="star">
                                            <i class="glyphicon glyphicon-star-empty"></i>
                                        </span>
                                        <span class="star">
                                            <i class="glyphicon glyphicon-star-empty"></i>
                                        </span>
                                        <span class="star">
                                            <i class="glyphicon glyphicon-star-empty"></i>
                                        </span>
                                    </span>
                                    <span class="filled-stars" style="width: <?= Helper::ratingDoctor($doctor->id) * 20?>%;">
                                        <span class="star">
                                            <i class="glyphicon glyphicon-star"></i>
                                        </span>
                                        <span class="star">
                                            <i class="glyphicon glyphicon-star"></i>
                                        </span>
                                        <span class="star">
                                            <i class="glyphicon glyphicon-star"></i>
                                        </span>
                                        <span class="star">
                                            <i class="glyphicon glyphicon-star"></i>
                                        </span>
                                        <span class="star">
                                            <i class="glyphicon glyphicon-star"></i>
                                        </span>
                                    </span>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <a href="<?= Helper::lang('doctor/'.$doctor->alias)?>?reviews=active" class="link"><?= Helper::ratingDoctorCount($doctor->id)?> <?= Yii::t('frontend', 'reviews')?></a>
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
<?php endif;?>
<?endforeach;?>
