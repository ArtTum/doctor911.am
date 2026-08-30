<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/19/2018
 * Time: 2:05 PM
 */

use common\components\Translate;
use kartik\rating\StarRating;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$page = \common\models\Page::findOne(['alias' => $alias]);
if(!empty($page)){
    $this->title = Translate::text($page->getLangHasPages(), 'meta_title');
    $this->registerMetaTag(['name' => 'keywords', 'content' => Translate::text($page->getLangHasPages(), 'meta_keys')]);
    $this->registerMetaTag(['name' => 'description', 'content' => Translate::text($page->getLangHasPages(), 'meta_description')]);

}elseif(isset($category)){
    $this->title = Translate::text($category->getLangHasCategories(), 'meta_title') ? Translate::text($category->getLangHasCategories(), 'meta_title') : $title;
    $this->registerMetaTag(['name' => 'keywords', 'content' => Translate::text($category->getLangHasCategories(), 'meta_keys')]);
    $this->registerMetaTag(['name' => 'description', 'content' => Translate::text($category->getLangHasCategories(), 'meta_description')]);
}

$this->params['breadcrumbs'][] = $title;


?>
<?if($alias == 'doctors'):?>
    <span style="display: none;" itemprop="description"> Doctor911 սերվիսը հնարավորություն է կատարել անհրաժեշտ բժշկի որոնում օնլայն: Service - bjishkner, bjshkakan xorhrdatvutyun Erevanum, Hayastanum - Doctor911</span>
    <span style="display: none;" itemprop="keywords"> bjshkakan xorhurd, bjshkakan xorhrdatvutyun, bjishkner, bjishkner am, hivandutyunner am, bjishkner hayastanum, bjishkner erevanum, bjishk online, bjshkakan kentronner</span>
<?else:?>
    <span style="display: none;" itemprop="description">Doctor911 սերվիսը ներկայացնում է լավագույն պլաստիկ վիրաբույժների Երևանում և Հայաստանում: Service - Plastik virahatutyun, plastik virabuyj Erevanum - Doctor911</span>
    <span style="display: none;" itemprop="keywords">plastik virabuyj, erevan, hayastan, plastik virahatutyun, պլաստիկ վիրահատություն, վիրաբույժ, gner</span>
<?endif?>
<style>


    .custom-select-wrapper, .custom-select-wrapper1 {
        position: relative;
        user-select: none;
        width: 100%;
    }
    .custom-select, .custom-select1 {
        position: relative;
        display: flex;
        flex-direction: column;
        border-width: 0 2px 0 2px;
        border-style: solid;
        border-color: #008022;
    }
    .custom-select__trigger {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 10px;
        font-size: 14px;
        font-weight: 300;
        color: #3b3b3b;
        height: 36px;
        line-height: 36px;
        background: #ffffff;
        cursor: pointer;
        border-width: 2px 0 2px 0;
        border-style: solid;
        border-color: #008022;
    }
    .custom-select__trigger1 {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 10px;
        font-size: 14px;
        font-weight: 300;
        color: #3b3b3b;
        height: 36px;
        line-height: 36px;
        background: #ffffff;
        cursor: pointer;
        border-width: 2px 0 2px 0;
        border-style: solid;
        border-color: #008022;
    }
    .custom-options, .custom-options1 {
        position: absolute;
        display: block;
        top: 100%;
        left: 0;
        right: 0;
        border: 2px solid #008022;
        border-top: 0;
        background: #fff;
        transition: all 0.5s;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        z-index: 2;
    }
    .custom-select.open .custom-options, .custom-select1.open1 .custom-options1 {
        opacity: 1;
        visibility: visible;
        pointer-events: all;
    }
    .custom-select1.open .custom-options1 {
        opacity: 1;
        visibility: visible;
        pointer-events: all;
    }
    .custom-option, .custom-option1 {
        position: relative;
        display: block;
        padding: 0 10px 0 10px;
        font-size: 14px;
        font-weight: 300;
        color: #3b3b3b;
        line-height: 36px;
        cursor: pointer;
        transition: all 0.5s;
    }
    .custom-option:hover, .custom-option1:hover {
        cursor: pointer;
        background-color: #b2b2b2;
    }
    .custom-option.selected, .custom-option1.selected {
        color: #ffffff;
        background-color: #008022;
    }

    .arrow {
        position: relative;
        height: 15px;
        width: 15px;
    }
    .arrow::before, .arrow::after {
        content: "";
        position: absolute;
        bottom: 0px;
        width: 0.15rem;
        height: 100%;
        transition: all 0.5s;
    }
    .arrow::before {
        left: -5px;
        transform: rotate(45deg);
        background-color: #008022;
    }
    .arrow::after {
        left: 5px;
        transform: rotate(-45deg);
        background-color: #008022;
    }
    .open .arrow::before, .open1 .arrow::before {
        left: -5px;
        transform: rotate(-45deg);
    }
    .open .arrow::after, .open1 .arrow::after {
        left: 5px;
        transform: rotate(45deg);
    }

</style>
<div class="container">

        <h1><?= $title?></h1>
    <?if($alias == 'doctors'):?>
        <?php $form = ActiveForm::begin([
            'options' => [
                'class' => 'row',
                'enctype' => 'multipart/form-data',
            ]
        ]); ?>

        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="custom-select-wrapper">
                <label><?= Yii::t('admin', 'Hospitals')?></label>
                <div class="custom-select">
                    <div class="custom-select__trigger"><span><?= $hospital_ ? mb_substr(Translate::text($hospital_->getLangHasHospitals(), 'name'),0, 30, 'UTF-8') : ''; ?></span>
                        <div class="arrow"></div>
                    </div>
                    <div class="custom-options">
                        <?foreach ($hospitals as $hospital):?>
                            <a href="/doctors/hospital-<?=$hospital->alias?>" class="custom-option <?= ($hospital->alias == Yii::$app->request->get('hospital') ? 'selected' : '')?>" data-value="tesla"><?= Translate::text($hospital->getLangHasHospitals(), 'name'); ?></a>
                        <?endforeach;?>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-4">
            <div class="custom-select-wrapper1">
                <label><?= Yii::t('frontend', 'Our Services')?></label>
                <div class="custom-select1">
                    <div class="custom-select__trigger1"><span><?= $category ? mb_substr( Translate::text($category->getLangHasCategories(), 'name'),0, 30, 'UTF-8') : ''; ?></span>
                        <div class="arrow"></div>
                    </div>
                    <div class="custom-options1">
                        <?foreach ($professions as $profession):?>
                            <a href="/doctors/hospital-<?=$hospital_->alias?>/profession-<?= $profession->category->alias?>" class="custom-option1 <?= ($profession->category->alias == Yii::$app->request->get('profession') ? 'selected' : '')?>" data-value="tesla"><?= Translate::text($profession->category->getLangHasCategories(), 'name'); ?></a>
                        <?endforeach;?>
                    </div>
                </div>
            </div>

        </div>

    <?php ActiveForm::end(); ?>
    <?endif;?>
    <div class="row">
        <?= $this->render('_items', [
            'doctors' => $doctors,
            'pages' => $pages,
        ]) ?>
        <div class="page-count" data-max="<?= round($count/$pages->limit) ? round($count/$pages->limit) : 1 ?>" id="content"></div>
        <p id="loading"><img  src='/images/loading.gif'></p>
        <div style="display: none">
            <?= StarRating::widget([
                'name' => 'url',
                'value' => 5,
                'class' => 'hide',
                'pluginOptions' => [
                    'disabled'=> true,
                    'showCaption' => false,
                    'showClear'=>false,
                    'size'=>'xs'
                ]
            ]);?>
        </div>
    </div>
</div>
