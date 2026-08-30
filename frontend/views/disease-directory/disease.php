<?php
/**
 * Created by PhpStorm.
 * User: artur999
 * Date: 10/18/2018
 * Time: 6:10 AM
 */

use common\components\Helper;
use common\components\Translate;
use yii\bootstrap\Html;
use yii\helpers\StringHelper;

$this->title = Translate::text($disease->getLangHasLibraries(), 'meta_title') ? Translate::text($disease->getLangHasLibraries(), 'meta_title')  : Translate::text($disease->getLangHasLibraries(), 'name');

$this->registerMetaTag(['name' => 'keywords', 'content' => Translate::text($disease->getLangHasLibraries(), 'meta_keys')]);
$this->registerMetaTag(['name' => 'description', 'content' => Translate::text($disease->getLangHasLibraries(), 'meta_description')]);


$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Disease Directory'), 'url' => [Helper::lang('disease-directory')]];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .doc-scroll{
        height: 1130px;
        overflow-y: scroll;
    }
    @media only screen and (max-width: 600px) {
        .doc-scroll{
            height: auto;
            overflow-y: hidden;
        }
    }
</style>
<div class="container">

    <div class="row ">
        <div class="single-disease">
            <!-- Post Content Column -->
            <div class="col-lg-8">
                <!-- Post Content -->
                <h1 class="lead"><?= Translate::text($disease->getLangHasLibraries(), 'name');?></h1>


                <?= str_replace("https://doc.ua/bolezn","/ru/disease",Translate::text($disease->getLangHasLibraries(), 'description'));?>

            </div>
            <div class="col-lg-4 doc-scroll" >
                <?foreach ($disease->doctors as $doctor):?>
                    <?if ($doctor->status == 1):?>
                    <div class="col-lg-12">
                        <div class="doctor row">
                            <div class="col-lg-5">
                                <a style="background-image: url(<?= "/uploads/doctors/".$doctor->image?>)" class="img-doctor" href="<?= Helper::lang('doctor/'.$doctor->alias)?>">
                                    <? Html::img("/uploads/doctors/".$doctor->image, ['class' => 'img-doctor', 'alt' => 'doctor-img'])?>
                                </a>
                            </div>
                            <div class="col-lg-7">
                                <div class="name">
                                    <a href="<?= Helper::lang('doctor/'.$doctor->alias)?>">
                                        <h6><?= Translate::text($doctor->getLangHasDoctors(), 'full_name'); ?></h6>
                                        <p><?= Translate::text($doctor->getLangHasDoctors(), 'doctor_info'); ?></p>
                                    </a>
                                    <?if($doctor->plastic_surgeon ):?>
                                        <a class="link" href="<?= Helper::lang('gallery/'.$doctor->alias)?>"><?= Yii::t('frontend', 'Photos')?></a>
                                    <?endif;?>
                                    <div class="row">

                                        <div class="col-lg-12">
                                            <button style="font-size: 10px;white-space: normal;" onclick="registerDoctor(<?= (int) $doctor->id ?>)" type="button" class="btn fix-button" data-toggle="modal" data-target="#exampleModal">
                                                <?= Yii::t('frontend', 'Register and get a discount')?>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?endif;?>
                <?endforeach;?>
            </div>
        </div>
    </div>
    <!-- /.row -->
    <br><br>
</div>
