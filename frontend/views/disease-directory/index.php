<?php
/**
 * Created by PhpStorm.
 * User: artur999
 * Date: 10/16/2018
 * Time: 11:25 AM
 */

$this->title = Yii::t('frontend', 'Disease Directory');
$this->params['breadcrumbs'][] = $this->title;


use common\components\Helper;

?>

<div class="container">
    <div class="row">
        <?if(Yii::$app->language == 'am'):?>

        <div class="col-md-12 alph">
            <ul class="alphabet">

                <?foreach ($abc_arm as $arm):?>
                    <? $let = ($arm == 'Ա') ? '' : '/'.$arm?>
                    <li>
                        <a class="<?= $letter == $arm ? 'active' : ''?>" href="<?= Helper::lang('disease-directory'.$let)?>"><?= $arm?></a>
                    </li>
                <?endforeach;?>
                <li style="clear: both"></li>
            </ul>
        </div>
        <?elseif (Yii::$app->language == 'ru'):?>
            <div class="col-md-12 alph">
                <ul class="alphabet">
                    <?foreach ($abc_rus as $rus):?>
                        <? $let = ($rus == 'А') ? '' : '/'.$rus?>
                        <li>
                            <a class="<?= $letter == $rus ? 'active' : ''?>" href="<?= Helper::lang('disease-directory'.$let)?>"><?= $rus?></a>
                        </li>
                    <?endforeach;?>
                </ul>
            </div>
        <?endif;?>

        <div class="something">
            <ul class="well">
                <?foreach ($disease_directory as $directory):?>
                <li class="col-md-3  col-xl-3 col-xs-6">
                    <a href="<?= Helper::lang('disease/'.$directory['alias'])?>"><?= $directory['name']?></a>
                </li>
                <?endforeach;?>
            </ul>
            <div class="clear"></div>

        </div>
    </div>
</div>
