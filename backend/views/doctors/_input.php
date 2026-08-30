<?php

use common\components\Translate;
use mihaildev\elfinder\ElFinder;
use mihaildev\ckeditor\CKEditor;

$full_name = Translate::translatable_key('full_name', $lang->id);
$doctor_info = Translate::translatable_key('doctor_info', $lang->id);
$tiny_text = Translate::translatable_key('tiny_text', $lang->id);
$description = Translate::translatable_key('description', $lang->id);
$meta_title = Translate::translatable_key('meta_title', $lang->id);
$meta_keys = Translate::translatable_key('meta_keys', $lang->id);
$meta_description = Translate::translatable_key('meta_description', $lang->id);

?>
<?= $form->field($model_lang, 'full_name')->textInput(['name' => "lang[$full_name]", 'value' => Translate::text($model->getLangHasDoctors(), 'full_name', $lang->iso)])->label() ?>
<?= $form->field($model_lang, 'doctor_info')->textInput(['name' => "lang[$doctor_info]",  'value' => Translate::text($model->getLangHasDoctors(), 'doctor_info', $lang->iso)])->label() ?>
<?= $form->field($model_lang, 'tiny_text')->textarea(['rows' => 6, 'name' => "lang[$tiny_text]", 'value' => Translate::text($model->getLangHasDoctors(), 'tiny_text', $lang->iso)])->label() ?>
<div class="form-group field-category-description">
    <label class="control-label" for="pages-description">Տեքստ</label>

    <?= CKEditor::widget([
        'name' => "lang[$description]",
        'value' => Translate::text($model->getLangHasDoctors(), 'description', $lang->iso),
        'options' => ['rows' => 6],
        'editorOptions' => ElFinder::ckeditorOptions('elfinder',[
            'preset' => 'full',
            'inline' => false,
            //'contentsCss' => '/css/style4963.css'
        ]),
    ]); ?>
</div>
<?= $form->field($model_lang, 'meta_title')->textInput(['name' => "lang[$meta_title]", 'value' => Translate::text($model->getLangHasDoctors(), 'meta_title', $lang->iso)])->label() ?>
<?= $form->field($model_lang, 'meta_keys')->textInput(['name' => "lang[$meta_keys]", 'value' => Translate::text($model->getLangHasDoctors(), 'meta_keys', $lang->iso)])->label() ?>
<?= $form->field($model_lang, 'meta_description')->textarea(['rows' => 6, 'name' => "lang[$meta_description]", 'value' => Translate::text($model->getLangHasDoctors(), 'meta_description', $lang->iso)])->label() ?>

