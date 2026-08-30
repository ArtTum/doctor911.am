<?php

use common\components\Translate;

$name = Translate::translatable_key('name', $lang->id);

?>
<?= $form->field($model_lang, 'name')->textInput(['name' => "lang[$name]", 'value' => Translate::text($model->getLangHasMenus(), 'name', $lang->iso)])->label() ?>
