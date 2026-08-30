<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="m-grid m-grid--hor m-grid--root m-page">
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-grid--tablet-and-mobile m-grid--hor-tablet-and-mobile m-login m-login--1 m-login--singin" id="m_login">
        <div class="m-grid__item m-grid__item--order-tablet-and-mobile-2 m-login__aside" style="margin: auto">
            <div class="m-stack m-stack--hor m-stack--desktop">
                <div class="m-stack__item m-stack__item--fluid">
                    <div class="m-stack m-stack--hor m-stack--desktop">
                            <div class="m-stack__item m-stack__item--fluid">
                                <div class="m-login__wrapper">
                                    <div class="m-login__logo">
                                        <a href="">
                                            <img src="https://doctor911.am/images/logoo.png">
                                        </a>
                                    </div>
                                    <div class="m-login__signin">

                                        <?php $form = ActiveForm::begin([
                                            'id' => 'login-form',
                                            'options' => [
                                                'class' => 'm-login__form m-form'
                                            ]
                                        ]); ?>
                                        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'username', 'class' => 'form-control m-input'])->label(false) ?>
                                        <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'password', 'class' => 'form-control m-input m-login__form-input--last'])->label(false) ?>
                                        <div class="m-login__form-action">
                                            <button  class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">
                                                Login
                                            </button>
                                        </div>
                                        <?php ActiveForm::end(); ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                </div>
            </div>
        </div>

    </div>
</div>
