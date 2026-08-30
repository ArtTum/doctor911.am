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
use common\widgets\Alert;
use kartik\rating\StarRating;

$this->title =  Translate::text($doctor->getLangHasDoctors(), 'meta_title');
$this->registerMetaTag(['name' => 'keywords', 'content' => Translate::text($doctor->getLangHasDoctors(), 'meta_keys')]);
$this->registerMetaTag(['name' => 'description', 'content' => Translate::text($doctor->getLangHasDoctors(), 'meta_description')]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', $doctor->plastic_surgeon ? 'Plastic Surgeons' : 'Doctors'), 'url' => [Helper::lang($doctor->plastic_surgeon ? 'plastic-surgeon' : 'doctors')]];
$this->params['breadcrumbs'][] = Translate::text($doctor->getLangHasDoctors(), 'full_name');
?>
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="item-one row">
                    <div class="col-lg-9">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="img-doctor-one" style="background-image: url(<?= "/uploads/doctors/".$doctor->image?>)">
                                    <? Html::img("/uploads/doctors/".$doctor->image, ['class' => 'img-doctor-one', 'alt' => 'doctor-img'])?>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="name">
                                    <h1><?= Translate::text($doctor->getLangHasDoctors(), 'full_name'); ?></h1>
                                    <p><?= Translate::text($doctor->getLangHasDoctors(), 'doctor_info'); ?></p>
                                    <p class="min-text">
                                        <?= Translate::text($doctor->getLangHasDoctors(), 'tiny_text'); ?>
                                    </p>
                                    <?if($doctor->plastic_surgeon ):?>
                                        <a class="link" href="<?= Helper::lang('gallery/'.$doctor->alias)?>"><?= Yii::t('frontend', 'Photos')?></a>
                                    <?endif;?>
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
                                                'value' => Helper::ratingDoctor($doctor->id),
                                                'pluginOptions' => [
                                                    'disabled'=> true,
                                                    'showCaption' => false,
                                                    'showClear'=>false,
                                                    'size'=>'sm'
                                                ]
                                            ]);?>
                                            <a href="?reviews=active" class="link"><?= Helper::ratingDoctorCount($doctor->id)?> <?= Yii::t('frontend', 'reviews')?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <iframe width="100%" height="250px" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                        <?= $doctor->map?>
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
                        <li class="<?= Yii::$app->request->get('reviews') == 'active' ? '' : 'active'?>"><a href="#tab1default" data-toggle="tab"><?= Yii::t('frontend', 'About the doctor')?></a></li>
                        <li class="<?= Yii::$app->request->get('reviews') == 'active' ? 'active' : ''?>"><a href="#tab2default" data-toggle="tab"><?= Yii::t('frontend', 'Reviews')?></a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade <?= Yii::$app->request->get('reviews') == 'active' ? '' : 'active'?>  in" id="tab1default">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h3 style="text-align:justify">
                                        <strong>
                                            <span style="font-size:18px">
                                                <?= Yii::t('frontend', 'Specialization')?>
                                            </span>
                                        </strong>
                                    </h3>
                                    <?if(!empty($doctor->libraries)):?>
                                        <ul>
                                            <?foreach ($doctor->libraries as $library):?>
                                                <li>
                                                    <a href="<?= Helper::lang('disease/'.$library->alias)?>">
                                                        <?= Translate::text($library->getLangHasLibraries(), 'name'); ?>
                                                    </a>
                                                </li>
                                            <?endforeach;?>
                                        </ul>
                                    <?endif;?>
                                    <?= Translate::text($doctor->getLangHasDoctors(), 'description'); ?>
                                </div>
                                <div class="col-lg-4">
                                    <div class="product-reviews">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade <?= Yii::$app->request->get('reviews') == 'active' ? 'active in' : ''?>" id="tab2default">
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
