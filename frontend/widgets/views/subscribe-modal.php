<?php
/**
 * Created by PhpStorm.
 * User: artur999
 * Date: 10/11/2018
 * Time: 6:39 PM
 */

use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;

?>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= Yii::t('frontend','Register and get a discount')?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php $form = ActiveForm::begin([
                'action' => '/add-subscribe',
                'id' => 'subscribe-form',
                'enableAjaxValidation' => false,
            ]); ?>
                <div class="modal-body">
                    <?= Html::activeHiddenInput($model, 'form_token') ?>
                    <?= Html::activeHiddenInput($model, 'doctor_id', ['value' => $doctor_id]) ?>
                    <?= Html::activeHiddenInput($model, 'hospital_id', ['value' => $hospital_id]) ?>

                    <div aria-hidden="true" style="position:absolute;left:-10000px;width:1px;height:1px;overflow:hidden;">
                        <?= Html::activeTextInput($model, 'website', [
                            'tabindex' => '-1',
                            'autocomplete' => 'off',
                        ]) ?>
                    </div>

                    <?= $form->field($model, 'full_name')->textInput([
                        'maxlength' => 80,
                        'autocomplete' => 'name',
                    ]) ?>

                    <?= $form->field($model, 'phone')->textInput(
                            [
                                'type' => 'tel',
                                'maxlength' => 30,
                                'autocomplete' => 'tel',
                                'placeholder' => '(+374) XX-XX-XX-XX',
                            ]
                    ) ?>

                    <?= $form->field($model, 'description')->textarea(['maxlength' => 1000]) ?>

                    <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
                        'captchaAction' => '/site/captcha',
                        'imageOptions' => [
                            'alt' => Yii::t('frontend', 'Verification Code'),
                            'title' => Yii::t('frontend', 'Click the image to get a new code.'),
                            'style' => 'cursor:pointer;margin-right:10px;',
                        ],
                        'options' => [
                            'class' => 'form-control',
                            'autocomplete' => 'off',
                            'maxlength' => 8,
                        ],
                    ]) ?>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= Yii::t('frontend', 'Close')?></button>
                    <button type="submit" class="btn btn-success"><?= Yii::t('frontend', 'Send')?></button>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
