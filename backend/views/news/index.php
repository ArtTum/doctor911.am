<?php

use common\components\Translate;
use fedemotta\datatables\DataTables;
use kotchuprik\sortable\grid\Column;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('admin', 'News');
$this->params['breadcrumbs'][] = $this->title;
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
    <!-- END: Subheader -->
    <div class="m-content col-xl-12 col-lg-12 col-md-12 col-xs-12">

        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            <?= Html::encode($this->title) ?>ի ցանկ
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <!--begin: Search Form -->
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="row align-items-center">
                        <div class="col-xl-8 order-2 order-xl-1">
                            <div class="form-group m-form__group row align-items-center">


                            </div>
                        </div>
                        <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                            <a href="<?= Url::to(['create'])?>" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span>
                                        Ավելացնել
                                    </span>
                                </span>
                            </a>
                            <div class="m-separator m-separator--dashed d-xl-none"></div>
                        </div>
                    </div>
                </div>
                <?= DataTables::widget([
                    'dataProvider' => $dataProvider,
                    'rowOptions' => function ($dataProvider, $key, $index, $grid) {
                        return ['data-sortable-id' => $dataProvider->id];
                    },

                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'image',
                            'format'=>'raw',
                            'value'=>function ($model, $index, $widget){
                                return Html::img("/uploads/news/".$model->image, ['width' => 70]);
                            }
                        ],
                        [
                            'label' => 'Անվանում',
                            'value' => function($model){ return Translate::text($model->getLangHasNews(), 'name'); }
                        ],
                        'alias',
                        [
                            'attribute' => 'status',
                            'value' => function($model){
                                return $model->status ? 'Ակտիվ' : 'Պասիվ';
                            }
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{update} {delete}',
                        ],
                    ],

                ]); ?>

            </div>
        </div>
    </div>
</div>
