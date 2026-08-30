<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = Yii::t('frontend', 'Contact');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <div class="page-header">
        <h1>
            <?= Html::encode($this->title) ?>
        </h1>
    </div>

    <!-- Contact with Map - START -->
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="well well-sm">
                    <?php $form = ActiveForm::begin(['id' => 'contact-form',
                        'options' => [
                            'class' => 'form-horizontal'
                        ]]); ?>
                        <fieldset>
                            <legend class="text-center header">Կապ մեզ հետ</legend>
                            <div class="form-group">
                                <div class="col-md-10 col-md-offset-1">
                                    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-10 col-md-offset-1">
                                    <?= $form->field($model, 'email') ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-10 col-md-offset-1">
                                    <?= $form->field($model, 'subject') ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-10 col-md-offset-1">
                                    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-10 col-md-offset-1">
                                    <?= Html::submitButton(Yii::t('frontend', 'Send'), ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                                </div>
                            </div>

                        </fieldset>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <div class="panel panel-default">
                        <div class="text-center header">Մեր գրասենյակը</div>
                        <div class="panel-body text-center row">

                            <div class="col-md-6">
                                <h4>Հեռախոսահամարներ</h4>
                                <a href="tel:(+374) 44 911 911">(+374) 44 911 911</a><br>
                                <a href="tel:(+374) 99 911 188">(+374) 99 911 188</a><br>
                                <a href="tel:(+374) 55 911 818">(+374) 55 911 818</a><br>
                                <a href="tel:(+374) 77 035 911">(+374) 77 035 911</a><br>
                                <a href="tel:(+374) 99 035 911">(+374) 99 035 911</a><br>
                            </div>
                            <div class="col-md-6">
                                <h4>Հասցե</h4>
                                ՀՀ, ք. Երևան, Կոմիտաս 51/4 3-րդ հարկ, 10 սենյակ<br/>
                                <a href="mailto:info@doctor911.am">info@doctor911.am</a><br/>
                                <span class="jamer_span">Աշխատանքային ժամերը` </span>
                                <label class="jamer_label">Երկուշաբթի-Շաբաթ ` 9:30 - 19:00</label>
                            </div>
                            <hr/>
                            <div id="map1" class="map">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d737.7902073590953!2d44.518339475050645!3d40.206411536204655!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x406abd3435009b43%3A0xe911056ae83c5980!2s51+Komitas+Ave%2C+Yerevan+0014%2C+Armenia!5e1!3m2!1sen!2s!4v1544427987230" width="100%" height="420" frameborder="0" style="border:0" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<style>
    .map {
        min-width: 300px;
        min-height: 300px;
        width: 100%;
        height: 100%;
    }

    .header {
        background-color: #F5F5F5;
        color: #36A0FF;
        height: 70px;
        font-size: 27px;
        padding: 10px;
    }
</style>
