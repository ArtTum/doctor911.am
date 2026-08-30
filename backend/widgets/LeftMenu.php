<?php

namespace backend\widgets;

use app\models\LeftMenu as Menu;
use common\components\Helper;
use Yii;
use yii\base\Widget;

class LeftMenu extends Widget {

    public function init() {
        parent::init();
    }

    public function run() {

        return $this->render("left-menu", [

        ]);
    }
}
?>