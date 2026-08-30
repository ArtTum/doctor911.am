<?php

use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model common\models\Category */

$this->title = Yii::t('admin', 'Update Help Info');
?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    <?= $this->title?>
                </h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="<?= Yii::$app->params['app']?>" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= Url::to(['/help-info'])?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                 Ինչպես օգտվել մեր ծառայություններից
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="" class="m-nav__link">
                            <span class="m-nav__link-text">
                                 <?= $this->title?>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
        'lang'  => $lang,
        'model_lang' => $model_lang,
    ]) ?>

</div>

