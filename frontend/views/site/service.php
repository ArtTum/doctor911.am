<?php
/**
 * Created by PhpStorm.
 * User: artur999
 * Date: 10/4/2018
 * Time: 8:39 PM
 */
use common\components\Translate;
use common\components\Helper;

$this->title = Yii::t('frontend', 'Our Services');
?>

<div id="services">
    <div class="container">
        <h1><?= Yii::t('frontend', 'Our Services')?></h1>
        <div class="row">
            <br>
            <?foreach ($services as $service):?>
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6 nopadding">
                    <div class="service">
                        <a href="<?= Helper::lang('service-doctor/'.$service->alias)?>">
                            <img src="/uploads/categories/45-45/<?= $service->image?>" alt="image">
                            <span class="border"></span>
                            <?= Translate::text($service->getLangHasCategories(), 'name')?>
                        </a>
                    </div>
                </div>
            <?endforeach;?>
        </div>
        <br>
        <br>
    </div>
</div>
