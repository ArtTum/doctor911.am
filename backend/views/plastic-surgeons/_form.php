<?php

use common\models\DoctorHasCategory;
use common\models\HospitalHasDoctor;
use common\models\HospitalHasType;
use yii\bootstrap\Tabs;
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
                    <div class="col-12">
                        <?if(!$model->isNewRecord):?>
                            <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>
                        <?endif;?>
                    </div>
                    <div class="form-group m-form__group col-6">
                        <div class="form-group">
                            <label>Նկար</label>
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 199px; height: 199px;">
                                    <img data-src="holder.js/100%x100%" alt="100%x100%" src="<?= $model->image ? '/uploads/doctors/'.$model->image : Yii::$app->params['app'].'/images/fa-camera.png'?>" style="width: 100%; display: block;">
                                </div>
                                <div>
                                    <?= $form->field($model, 'image')->fileInput(['maxlength' => true, 'class' => 'hide'])->label(false) ?>
                                </div>
                            </div>
                            <div class="image-buttons-other">
                                <a href="javascript:" id="uploads">Փոխել նկարը</a>
                            </div>
                        </div>
                    </div>

                    <div class="form-group m-form__group col-12">

                        <?
                        foreach($lang as $item){
                            $tabs['items'][] =  [
                                'label' => $item->name,
                                'content' => $this->render('_input', [
                                    'model' => $model,
                                    'lang'  => $item,
                                    'form' => $form,
                                    'model_lang' => $model_lang,
                                ]),
                            ];
                        }
                        ?>
                        <?= Tabs::widget($tabs);?>

                    </div>
                    <div class="form-group m-form__group col-12">
                        <?= $form->field($model_hospital, 'hospital_id')->checkboxList(
                            $data_hospital, [
                            'item' =>
                                function ($index, $label, $name, $checked, $value) {
                                    $v = HospitalHasDoctor::findOne(['hospital_id' => $value, 'doctor_id' => Yii::$app->request->get('id')]);

                                    if ($value == $v['hospital_id']) {
                                        $checked = true;
                                    }

                                    return Html::checkbox($name, $checked, [
                                        'value' => $value,
                                        'label' => '<label for="hospital_' . $value . '">' . $label . '</label>',
                                        'labelOptions' => [
                                            'class' => 'ckbox ckbox-primary col-6',
                                        ],
                                        'id' => 'hospital_'.$value,
                                    ]);
                                },
                            'separator'=>false,'template'=>'<div class="item">{input}{label}</div>',]);
                        ?>
                    </div>

                    <div class="form-group m-form__group col-12">
                        <?= $form->field($model_category, 'category_id')->checkboxList(
                            $data_category, [
                            'item' =>
                                function ($index, $label, $name, $checked, $value) {
                                    $v = DoctorHasCategory::findOne(['category_id' => $value, 'doctor_id' => Yii::$app->request->get('id')]);

                                    if ($value == $v['category_id']) {
                                        $checked = true;
                                    }

                                    return Html::checkbox($name, $checked, [
                                        'value' => $value,
                                        'label' => '<label for="category_' . $value . '">' . $label . '</label>',
                                        'labelOptions' => [
                                            'class' => 'ckbox ckbox-primary col-6',
                                        ],
                                        'id' => 'category_'.$value,
                                    ]);
                                },
                            'separator'=>false,'template'=>'<div class="item">{input}{label}</div>',]);
                        ?>
                    </div>

                    <div class="form-group m-form__group col-6">
                        <?= $form->field($model, 'status')->dropDownList(['1' => "Ակտիվ", '0' => "Պասիվ"], [
                            'class' => 'form-control m-select2',
                            'id' => 'm_select2_1_validate',
                        ]);
                        ?>


                    </div>
                    <div class="form-group m-form__group col-12">
                        <?= $form->field($model, 'sale')->textInput(['maxlength' => true, 'rows' => 6]) ?>
                        <?= $form->field($model, 'map')->textarea(['maxlength' => true, 'rows' => 6]) ?>
                    </div>

                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions--right">
                        <div class="row">
                            <div class="col m--align-left">
                                <?= Html::submitButton('Պահպանել', ['class' => 'btn btn-brand ']) ?>
                                <?= Html::a('Չեղարկել', ['/plastic-surgeons'], ['class' => 'btn btn-secondary'])?>
                            </div>
                            <?if(!$model->isNewRecord):?>
                                <div class="col m--align-right">
                                    <?= Html::a(Yii::t('admin', 'Ջնջել'), ['delete', 'id' => $model->id], [
                                        'class' => 'btn btn-danger',
                                        'data' => [
                                            'confirm' => Yii::t('admin', 'Վստահ եք, որ ցանկանում եք ջնջել այս տարրը?'),
                                            'method' => 'post',
                                        ],
                                    ]) ?>
                                </div>
                            <?endif;?>
                        </div>
                    </div>
                </div>
                <!--end::Form-->
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

