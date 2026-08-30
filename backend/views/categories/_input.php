<?php

use common\components\Translate;

$name = Translate::translatable_key('name', $lang->id);
$meta_title = Translate::translatable_key('meta_title', $lang->id);
$meta_keys = Translate::translatable_key('meta_keys', $lang->id);
$meta_description = Translate::translatable_key('meta_description', $lang->id);

?>
<?= $form->field($model_lang, 'name')->textInput(['name' => "lang[$name]", 'value' => Translate::text($model->getLangHasCategories(), 'name', $lang->iso)])->label() ?>
<?= $form->field($model_lang, 'meta_title')->textInput(['name' => "lang[$meta_title]", 'value' => Translate::text($model->getLangHasCategories(), 'meta_title', $lang->iso)])->label() ?>
<?= $form->field($model_lang, 'meta_keys')->textInput(['name' => "lang[$meta_keys]", 'value' => Translate::text($model->getLangHasCategories(), 'meta_keys', $lang->iso)])->label() ?>
<?= $form->field($model_lang, 'meta_description')->textarea(['rows' => 6, 'name' => "lang[$meta_description]", 'value' => Translate::text($model->getLangHasCategories(), 'meta_description', $lang->iso)])->label() ?>

