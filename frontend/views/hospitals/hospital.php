<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/19/2018
 * Time: 5:00 PM
 */

use yii\bootstrap\ActiveForm;
use common\components\Helper;
use common\components\Translate;
use yii\helpers\Html;
use kartik\rating\StarRating;
use common\widgets\Alert;
$this->title = Translate::text($hospital->getLangHasHospitals(), 'meta_title') ? Translate::text($hospital->getLangHasHospitals(), 'meta_title') : Translate::text($hospital->getLangHasHospitals(), 'name');
$this->params['breadcrumbs'][] = ['label' => Translate::text($types->getLangHasTypes(), 'name'), 'url' => [Helper::lang($types->alias)]];
$this->params['breadcrumbs'][] = Translate::text($hospital->getLangHasHospitals(), 'name');
?>
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="item-one row">
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="img-hospital-one" style="background-image: url(<?= "/uploads/hospitals/".$hospital->image?>)">
                                <? Html::img("/uploads/hospitals/".$hospital->image, ['class' => 'img-hospital-one', 'alt' => 'hospital-img'])?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="name">
                                <h1><?= Translate::text($hospital->getLangHasHospitals(), 'name'); ?></h1>
                                <p class="min-text">
                                    <?= Translate::text($hospital->getLangHasHospitals(), 'tiny_text'); ?>
                                </p>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="button" class="btn fix-button" data-toggle="modal" data-target="#exampleModal">
                                            <?= Yii::t('frontend', 'Register and get a discount')?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="doctor-star">
                                        <?= StarRating::widget([
                                            'name' => 'url',
                                            'value' => Helper::ratingHospital($hospital->id),
                                            'pluginOptions' => [
                                                'disabled'=>  true,
                                                'showCaption' => false,
                                                'showClear'=> false,
                                                'size'=>'sm'
                                            ]
                                        ]);?>
                                        <a class="link"><?= Helper::ratingHospitalCount($hospital->id)?> <?= Yii::t('frontend', 'reviews')?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <iframe width="100%" height="250px" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                    <?= $hospital->map?>
                    <div class="soc" style="padding-bottom: 10px">
                        <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
                        <script src="//yastatic.net/share2/share.js"></script>
                        <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,moimir,gplus" data-counter=""></div>
                    </div>
                </div>
            </div>
            <?= Alert::widget() ?>
            <div class="panel with-nav-tabs panel-default">
                <div class="panel-heading">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab1default" data-toggle="tab"><?= Yii::t('frontend', 'About Medical Institution')?></a></li>
                        <li class=""><a href="#tab2default" data-toggle="tab"><?= Yii::t('frontend', 'Reviews')?></a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="tab1default">
                            <div class="row">
                                <div class="col-lg-9">
                                    <?= Translate::text($hospital->getLangHasHospitals(), 'description'); ?>
                                </div>
                                <div class="col-lg-3">
                                    <div class="product-reviews">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab2default">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="comments-list">
                                        <?foreach ($comments as $comment):?>
                                            <div class="media">
                                                <?if(!empty($comment->star)):?>
                                                    <p class="pull-right">
                                                        <small>
                                                            <?= StarRating::widget([
                                                                'name' => 'url-'.$comment->id,
                                                                'value' => $comment->star,
                                                                'pluginOptions' => [
                                                                    'disabled'=> Yii::$app->user->isGuest ? true : false,
                                                                    'showCaption' => false,
                                                                    'showClear'=>false,
                                                                    'size'=>'xs'
                                                                ]
                                                            ]);?>
                                                        </small>
                                                    </p>
                                                <?endif;?>
                                                <div class="media-body ">
                                                    <h4 class="media-heading user_name"><?= $comment->first_name?> <?= $comment->last_name?></h4>
                                                    <?= $comment->text?>
                                                </div>
                                            </div>
                                        <?endforeach;?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="comment">
                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
                    <div class="row">
                        <div class="col-lg-4">
                            <?= $form->field($model, 'first_name')->textInput() ?>
                        </div>
                        <div class="col-lg-4">
                            <?= $form->field($model, 'last_name')?>
                        </div>

                        <div class="col-lg-4">
                            <?= $form->field($model, 'phone') ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8">
                            <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>
                        </div>
                        <div class="col-lg-4">
                            <?= $form->field($model, 'star')->widget(StarRating::classname(), [
                                'pluginOptions' => [
                                    'size'=>'md',
                                    'showCaption' => false,
                                    'showClear'=>false,
                                ]
                            ]);?>

                        </div>
                    </div>
                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('frontend', 'Leave a Review'), ['class' => 'btn fix-button', 'name' => 'contact-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>
</div>
