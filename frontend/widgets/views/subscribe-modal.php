<?php
/**
 * Created by PhpStorm.
 * User: artur999
 * Date: 10/11/2018
 * Time: 6:39 PM
 */

use yii\bootstrap\ActiveForm;

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
                'action' => '/add-subscribe'
            ]); ?>
                <div class="modal-body">
                    <input type="hidden" name="token" value="077999033">
                    <?= $form->field($model, 'full_name')->textInput() ?>

                    <?= $form->field($model, 'phone')->textInput(
                            ['placeholder' => '(+374) XX-XX-XX-XX']
                    ) ?>

                    <?= $form->field($model, 'description')->textarea() ?>

                    <?= $form->field($model, 'doctor')->hiddenInput(['value' => $doctor_name])->label(false) ?>
                    <?= $form->field($model, 'hospital')->hiddenInput(['value' => $hospital_name])->label(false) ?>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= Yii::t('frontend', 'Close')?></button>
                    <button type="submit" class="btn btn-success"><?= Yii::t('frontend', 'Send')?></button>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
