<?php
?>
<ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow " id="testDiv">

    <li class="m-menu__item">
        <a href="<?= Yii::$app->params['app']?>" class="m-menu__link ">
            <i class="m-menu__link-icon flaticon-line-graph"></i>
            <span class="m-menu__link-title">
                <span class="m-menu__link-wrap">
                    <span class="m-menu__link-text">
                        Վահանակ
                    </span>
                </span>
            </span>
        </a>
    </li>
    <li class="m-menu__item">
        <a href="<?= Yii::$app->params['app']?>/hospitals" class="m-menu__link ">
            <i class="m-menu__link-icon flaticon-line-graph"></i>
            <span class="m-menu__link-title">
                <span class="m-menu__link-wrap">
                    <span class="m-menu__link-text">
                        Բուժհաստատություններ
                    </span>
                </span>
            </span>
        </a>
    </li>
    <li class="m-menu__item">
        <a href="<?= Yii::$app->params['app']?>/doctors" class="m-menu__link ">
            <i class="m-menu__link-icon flaticon-line-graph"></i>
            <span class="m-menu__link-title">
                <span class="m-menu__link-wrap">
                    <span class="m-menu__link-text">
                        Բժիշկներ
                    </span>
                </span>
            </span>
        </a>
    </li>
    <li class="m-menu__item">
        <a href="<?= Yii::$app->params['app']?>/plastic-surgeons" class="m-menu__link ">
            <i class="m-menu__link-icon flaticon-line-graph"></i>
            <span class="m-menu__link-title">
                <span class="m-menu__link-wrap">
                    <span class="m-menu__link-text">
                        Պլաստիկ վիրաբույժներ
                    </span>
                </span>
            </span>
        </a>
    </li>
    <li class="m-menu__item">
        <a href="<?= Yii::$app->params['app']?>/galleries" class="m-menu__link ">
            <i class="m-menu__link-icon flaticon-line-graph"></i>
            <span class="m-menu__link-title">
                <span class="m-menu__link-wrap">
                    <span class="m-menu__link-text">
                        Պլաստիկ վիրաբույժներ - Նկարներ
                    </span>
                </span>
            </span>
        </a>
    </li>
    <li class="m-menu__item  m-menu__item--submenu m-menu__item--open m-menu__item--expanded">
        <a href="#" class="m-menu__link m-menu__toggle">
            <i class="m-menu__link-icon flaticon-multimedia-1"></i>
            <span class="m-menu__link-text">Մենյուներ</span>
            <i class="m-menu__ver-arrow la la-angle-right"></i>
        </a>
        <div class="m-menu__submenu">
            <span class="m-menu__arrow"></span>
            <ul class="m-menu__subnav">

                <li class="m-menu__item ">
                    <a href="<?= Yii::$app->params['app']?>/menu" class="m-menu__link ">
                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                            <span></span>
                        </i>
                        <span class="m-menu__link-text">Մենյու</span>
                    </a>
                </li>
                <li class="m-menu__item ">
                    <a href="<?= Yii::$app->params['app']?>/footer-menu" class="m-menu__link ">
                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                            <span></span>
                        </i>
                        <span class="m-menu__link-text">Ներքևի մենյու</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>
    <li class="m-menu__item">
        <a href="<?= Yii::$app->params['app']?>/categories" class="m-menu__link ">
            <i class="m-menu__link-icon  flaticon-truck"></i>
            <span class="m-menu__link-title">
                <span class="m-menu__link-wrap">
                    <span class="m-menu__link-text">
                        Մասնագիտություններ
                    </span>
                </span>
            </span>
        </a>
    </li>
    <li class="m-menu__item">
        <a href="<?= Yii::$app->params['app']?>/types" class="m-menu__link ">
            <i class="m-menu__link-icon flaticon-tabs"></i>
            <span class="m-menu__link-title">
                <span class="m-menu__link-wrap">
                    <span class="m-menu__link-text">
                        Տեսակներ
                    </span>
                </span>
            </span>
        </a>
    </li>
    <li class="m-menu__item">
        <a href="<?= Yii::$app->params['app']?>/help-info" class="m-menu__link ">
            <i class="m-menu__link-icon flaticon-suitcase"></i>
            <span class="m-menu__link-title">
                <span class="m-menu__link-wrap">
                    <span class="m-menu__link-text">
                        Ինչպես օգտվել
                    </span>
                </span>
            </span>
        </a>
    </li>
    <li class="m-menu__item">
        <a href="<?= Yii::$app->params['app']?>/news" class="m-menu__link ">
            <i class="m-menu__link-icon flaticon-suitcase"></i>
            <span class="m-menu__link-title">
                <span class="m-menu__link-wrap">
                    <span class="m-menu__link-text">
                        Նորություններ
                    </span>
                </span>
            </span>
        </a>
    </li>
    <li class="m-menu__item">
        <a href="<?= Yii::$app->params['app']?>/libraries" class="m-menu__link ">
            <i class="m-menu__link-icon flaticon-suitcase"></i>
            <span class="m-menu__link-title">
                <span class="m-menu__link-wrap">
                    <span class="m-menu__link-text">
                       Հիվանդությունների տեղեկատու
                    </span>
                </span>
            </span>
        </a>
    </li>
    <li class="m-menu__item">
        <a href="<?= Yii::$app->params['app']?>/socials" class="m-menu__link ">
            <i class="m-menu__link-icon flaticon-suitcase"></i>
            <span class="m-menu__link-title">
                <span class="m-menu__link-wrap">
                    <span class="m-menu__link-text">
                        Սոց․ ցանցեր
                    </span>
                </span>
            </span>
        </a>
    </li>
    <li class="m-menu__item">
        <a href="<?= Yii::$app->params['app']?>/pages" class="m-menu__link ">
            <i class="m-menu__link-icon flaticon-suitcase"></i>
            <span class="m-menu__link-title">
                <span class="m-menu__link-wrap">
                    <span class="m-menu__link-text">
                        Ստանդարտ էջեր
                    </span>
                </span>
            </span>
        </a>
    </li>
    <li class="m-menu__item">
        <a href="<?= Yii::$app->params['app']?>/comments" class="m-menu__link ">
            <i class="m-menu__link-icon flaticon-suitcase"></i>
            <span class="m-menu__link-title">
                <span class="m-menu__link-wrap">
                    <span class="m-menu__link-text">
                        Կարծիքներ
                    </span>
                </span>
            </span>
        </a>
    </li>
</ul>