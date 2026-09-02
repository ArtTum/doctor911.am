<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin([
    'options' => [
        'class' => 'm-form',
        'enctype' => 'multipart/form-data',
    ]
]); ?>
<div class="m-content">
    <div class="row">
        <div class="col-md-12">
            <!--begin::Portlet-->
            <div class="m-portlet m-portlet--space">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                Կատեգորիաի տվյալներ
                            </h3>
                        </div>
                    </div>
                </div>
                <!--begin::Form-->

                <div class="m-portlet__body row">

                    <div class="form-group m-form__group col-6">

                        <?= $form->field($model, 'doctor_id')->dropDownList(
                            $plastic_surgeon, [
                            'prompt' => '',
                            'class' => 'form-control m-select2',
                            'id' => 'm_select2_14status_validate',
                        ]);
                        ?>
                    </div>

                    <div class="form-group m-form__group col-12">
                        <div class="form-group">
                            <label>Նկար</label>
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 199px; height: 199px;">
                                    <img data-src="holder.js/100%x100%" alt="100%x100%" src="<?= $model->path ? $model->path : Yii::$app->params['app'].'/images/fa-camera.png'?>" style="width: 100%; display: block;">
                                </div>
                                <div>
                                    <?= $form->field($model, 'path')->fileInput(['maxlength' => true, 'class' => 'hide'])->label(false) ?>
                                </div>
                            </div>
                            <div class="image-buttons-other">
                                <a href="javascript:" id="uploads">Փոխել նկարը</a>
                            </div>
                        </div>
                    </div>


                    <div class="form-group m-form__group col-12">
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'order')->textInput(['maxlength' => true]) ?>
                    </div>

                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions--right">
                        <div class="row">
                            <div class="col m--align-left">
                                <?= Html::submitButton('Պահպանել', ['class' => 'btn btn-brand ']) ?>
                                <?= Html::a('Չեղարկել', ['/galleries'], ['class' => 'btn btn-secondary'])?>
                            </div>
                            <?php if(!$model->isNewRecord):?>
                                <div class="col m--align-right">
                                    <?= Html::a(Yii::t('admin', 'Ջնջել'), ['delete', 'id' => $model->id], [
                                        'class' => 'btn btn-danger',
                                        'data' => [
                                            'confirm' => Yii::t('admin', 'Վստահ եք, որ ցանկանում եք ջնջել այս տարրը?'),
                                            'method' => 'post',
                                        ],
                                    ]) ?>
                                </div>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
                <!--end::Form-->
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
