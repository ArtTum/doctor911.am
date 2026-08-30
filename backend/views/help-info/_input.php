<?php

use common\components\Translate;

$text = Translate::translatable_key('text', $lang->id);

?>
<?= $form->field($model_lang, 'text')->textarea(['rows' => 6, 'name' => "lang[$text]", 'value' => Translate::text($model->getLangHasHelpInfos(), 'text', $lang->iso)])->label() ?>

