<?php
/**
 * Created by PhpStorm.
 * User: artur999
 * Date: 11/20/2018
 * Time: 2:43 PM
 */

$this->title = 'Gallery';


use common\components\Helper;
use common\components\Translate;
use yii\helpers\Html;

$this->title = Translate::text($doctor->getLangHasDoctors(), 'full_name');
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Doctors'), 'url' => [Helper::lang('plastic-surgeon')]];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="container gallery-container">

    <h1><?= Translate::text($doctor->getLangHasDoctors(), 'full_name');?></h1>
    <h2><?= Yii::t('frontend', 'Works');?></h2>

    <div class="tz-gallery">

        <?foreach ($doctor->getGaleries()->orderBy(['order' => SORT_ASC])->all() as $k => $galery):?>
            <div class="<?= is_float(($k+1) / 3) ? '' : 'row'?>">
                <div class="col-sm-6 col-md-4 gallery-div">
                    <a class="lightbox" href="<?= $galery->path?>">
                        <img src="<?= $galery->path?>" alt="<?= $galery->name?>">
                    </a>
                </div>
            </div>
        <?endforeach;?>

    </div>

</div>