<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\components\Helper;
use common\components\Translate;

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;


$menu = \common\models\Menu::find()->orderBy(['order' => SORT_ASC])->all();
$footer_menu = \common\models\FooterMenu::find()->orderBy(['order' => SORT_ASC])->all();
$footer_text = \common\models\Page::findOne(['alias' => 'footer-text']);
$socials = \common\models\Social::find()->orderBy(['order' => SORT_ASC])->all();

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="mailru-domain" content="sXdYXqVsJVHOPGqJ" />
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
    <header class="hidden-xs hidden-sm">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <a href="<?= Helper::lang()?>"><img src="/images/logoo.png" class="logo-home"></a>
                </div>
                <div class="paragraph col-md-5">
                    <div class="one">
                        <p><?= Yii::t('frontend', 'YOUR QUICK AND QUALITY')?></p>
                    </div>
                    <div class="two">
                        <p><?= Yii::t('frontend', 'GUIDE IN THE SPHERE')?></p>
                    </div>
                    <div class="three">
                        <p><?= Yii::t('frontend', 'OF HEALTH CARE')?></p>
                    </div>
                </div>
                <div class="col-md-2">
                    <img src="/images/phone.png" alt="Phone" class="phone_icon">
                    <ul class="phone right">
                        <li><a href="tel:+37444911911">(+374)44 911 911</a></li>
                        <li><a href="tel:+37499911188">(+374)99 911 188</a></li>
                        <li><a href="tel:+37477035911">(+374)77 035 911</a></li>
                    </ul>
                </div>
                <div class=" col-md-2">
                    <div class="buttom">
                        <button type="button" class="btn" data-toggle="modal" data-target="#exampleModal">
                            <?= Yii::t('frontend', 'Register')?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <?php

    NavBar::begin([
        'brandLabel' => Html::img('/images/logoo.png', ['class' => 'hidden-lg hidden-md logo-home']),
        'brandUrl' => Helper::lang(),
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    $menuItems  = [];

    foreach ($menu as $m){

        if(!empty($m->subMenus)){
            $items = [];

            foreach ($m->getSubMenus()->orderBy(['order' => SORT_ASC])->all() as $subMenu){
                $items[] = [
                    'label' => Translate::text($subMenu->getLangHasSubMenus(), 'name'),
                    'url' => [Helper::lang($subMenu->url)],
                ];
            }
            $menuItems[] = [
                'label' => Translate::text($m->getLangHasMenus(), 'name'),
                'items' => $items,
            ];
        }else{
            $menuItems[] = [
                'label' => Translate::text($m->getLangHasMenus(), 'name'),
                'url' => [Helper::lang($m->url)],
            ];
        }
    }




    echo Nav::widget([
        'options' => ['class' => 'navbar-nav menu  navbar-left'],
        'items' => $menuItems,
    ]);
    ?>
    <ul class="navbar-nav hidden-sm navbar-right nav">
        <?foreach(Helper::languageUrl() as $lang):?>
            <li class="<?= Yii::$app->language == $lang['iso'] ? 'active' : ''?>"><a class="<?= Yii::$app->language == $lang['iso'] ? 'active' : ''?>" href="<?= $lang['url']?>"><?= $lang['flag']?></a></li>
        <?endforeach;?>
    </ul>

    <? echo '<div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 top-search hidden">
                <div class="header_search">
                    <form  class="form_search" action="'.Helper::lang('search').'" method="post">
                        <input type="text" name="search" class="search-top" placeholder="'.Yii::t('frontend', 'Search').' ..." autocomplete="off">
                        <div class="search_five_res"></div>
                        <input type="submit" name="ok_serach" value="" class="ok_search">
                    </form>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-4 top-search hidden">
                <div class="dropdown header-dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <span style="padding: 3px;" class="glyphicon glyphicon-earphone"></span>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><a href="tel:+37444911911" data-value="action"><img class="ucom" src="/images/u.png" alt="ucom"> +374 44 911 911</a></li>
                        <li><a href="tel:+37499911188" data-value="another action"><img class="beeline" src="/images/b.png" alt="beeline"> +374 99 911 188</a></li>
                        <li><a href="tel:+37477035911" data-value="something else here"><img class="viva" src="/images/v.png" alt="viva"> +374 77 035 911</a></li>
                    </ul>
                </div>
                <div class="phone_fixed mobile_hidden">
                   <a style="color: rgba(0, 0, 0, 0.5)" href="tel:+37444911911"><img class="ucom" src="/images/u.png" alt="ucom"> +(374)44 911 911</a>
                </div>
            </div>
             <div class="top-search col-lg-1 col-md-1 col-sm-1 hidden">
                <button type="button" class="btn fix-button" data-toggle="modal" data-target="#exampleModal">
                    '.Yii::t('frontend', 'Register').'
                </button>
            </div>
            </div>';
    NavBar::end();
    ?>
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
    </div>
    <?= $content ?>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <div class="down">
                        <div class="logo-right">
                            <a href="/"><img src="/images/logo.png"></a>
                            <div>
                                <?= Translate::text($footer_text->getLangHasPages(), 'description')?>
                            </div>

                            <p><a style="color: white" href="tel:+37444911911">+(374)44 911 911</a></p>

                            <p>info@doctor911.am</p>


                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <? if (!empty($menu)):?>
                    <div class="drop">
                        <h6><?= Yii::t('frontend', 'Information')?></h6>
                        <ul>
                            <?foreach ($menu as $m):?>
                                <li>
                                    <a href="<?= Helper::lang($m->url)?>"><?= Translate::text($m->getLangHasMenus(), 'name')?></a>
                                </li>
                            <?endforeach;?>
                        </ul>
                    </div>
                    <?endif;?>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <?if(!empty($footer_menu)):?>
                    <div class="drop">
                        <h6><?= Yii::t('frontend', 'For visitors')?></h6>
                        <ul>
                            <?foreach ($footer_menu as $f_menu):?>
                            <li>
                                <a href="<?= Helper::lang($f_menu->url)?>"><?= Translate::text($f_menu->getLangHasFooterMenus(), 'name')?></a>
                            </li>
                            <?endforeach;?>
                        </ul>
                        <?foreach ($socials as $social):?>
                            <a target="_blank" title="<?= $social->name?>" href="<?= $social->url?>">
                                <?= $social->icon?>
                            </a>
                        <? endforeach;?>
                    </div>
                    <?endif;?>
                </div>
            </div>
        </div>
        <div id="last">
            <div class="container">
                <span>&reg; 2016 - <?= date('Y') ?> <?= Yii::t('frontend','All rights reserved')?></span>
            </div>
        </div>
    </footer>
<?= \frontend\widgets\SubscribeModal::widget()?>

<!--<span  id="myMed"  class="">-->
<!--    <img src="/images/medlogo.png">-->
<!--    <p>Օնլայն դեղատուն</p>-->
<!--    <a class="btn fix-button" target="_blank" href="https://www.med911.am/">-->
<!--        Պատվիրել Հիմա-->
<!--    </a>-->
<!--</span>-->

<button onclick="scrollToTop()" id="myBtn" title="Go to top">
    <span class="glyphicon glyphicon-hand-up"></span>
</button>
<button data-toggle="modal" data-target="#phoneModal" id="myBtnPhone" title="Phone">
    <svg class="b24-crm-button-icon" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 30">
        <path class="b24-crm-button-call-icon" fill="#ebebeb" fill-rule="evenodd" d="M940.872414,978.904882 C939.924716,977.937215 938.741602,977.937215 937.79994,978.904882 C937.08162,979.641558 936.54439,979.878792 935.838143,980.627954 C935.644982,980.833973 935.482002,980.877674 935.246586,980.740328 C934.781791,980.478121 934.286815,980.265859 933.840129,979.97868 C931.757607,978.623946 930.013117,976.882145 928.467826,974.921839 C927.701216,973.947929 927.019115,972.905345 926.542247,971.731659 C926.445666,971.494424 926.463775,971.338349 926.6509,971.144815 C927.36922,970.426869 927.610672,970.164662 928.316918,969.427987 C929.300835,968.404132 929.300835,967.205474 928.310882,966.175376 C927.749506,965.588533 927.206723,964.77769 926.749111,964.14109 C926.29156,963.50449 925.932581,962.747962 925.347061,962.154875 C924.399362,961.199694 923.216248,961.199694 922.274586,962.161118 C921.55023,962.897794 920.856056,963.653199 920.119628,964.377388 C919.437527,965.045391 919.093458,965.863226 919.021022,966.818407 C918.906333,968.372917 919.274547,969.840026 919.793668,971.269676 C920.856056,974.228864 922.473784,976.857173 924.43558,979.266977 C927.085514,982.52583 930.248533,985.104195 933.948783,986.964613 C935.6148,987.801177 937.341181,988.444207 939.218469,988.550339 C940.510236,988.625255 941.632988,988.288132 942.532396,987.245549 C943.148098,986.533845 943.842272,985.884572 944.494192,985.204083 C945.459999,984.192715 945.466036,982.969084 944.506265,981.970202 C943.359368,980.777786 942.025347,980.091055 940.872414,978.904882 Z M940.382358,973.54478 L940.649524,973.497583 C941.23257,973.394635 941.603198,972.790811 941.439977,972.202844 C940.97488,970.527406 940.107887,969.010104 938.90256,967.758442 C937.61538,966.427182 936.045641,965.504215 934.314009,965.050223 C933.739293,964.899516 933.16512,965.298008 933.082785,965.905204 L933.044877,966.18514 C932.974072,966.707431 933.297859,967.194823 933.791507,967.32705 C935.117621,967.682278 936.321439,968.391422 937.308977,969.412841 C938.23579,970.371393 938.90093,971.53815 939.261598,972.824711 C939.401641,973.324464 939.886476,973.632369 940.382358,973.54478 Z M942.940854,963.694228 C940.618932,961.29279 937.740886,959.69052 934.559939,959.020645 C934.000194,958.902777 933.461152,959.302642 933.381836,959.8878 L933.343988,960.167112 C933.271069,960.705385 933.615682,961.208072 934.130397,961.317762 C936.868581,961.901546 939.347628,963.286122 941.347272,965.348626 C943.231864,967.297758 944.53673,969.7065 945.149595,972.360343 C945.27189,972.889813 945.766987,973.232554 946.285807,973.140969 L946.55074,973.094209 C947.119782,972.993697 947.484193,972.415781 947.350127,971.835056 C946.638568,968.753629 945.126778,965.960567 942.940854,963.694228 Z" transform="translate(-919 -959)"></path>
    </svg>
</button>

<!-- Modal -->
<div class="modal fade" id="phoneModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog  modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="phone-modal">
                    <li><a href="tel:+37444911911" data-value="action"><img class="ucom" src="/images/u.png" alt="ucom"> +374 44 911 911</a></li>
                    <li><a href="tel:+37499911188" data-value="another action"><img class="beeline" src="/images/b.png" alt="beeline"> +374 99 911 188</a></li>
                    <li><a href="tel:+37477035911" data-value="something else here"><img class="viva" src="/images/v.png" alt="viva"> +374 77 035 911</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php $this->endBody() ?>
<script type="text/javascript">
    function scrollToTop() {
        if (document.body.scrollTop!=0 || document.documentElement.scrollTop!=0){
            window.scrollBy(0,-50);
            timeOut=setTimeout('scrollToTop()',10);
        }
        else clearTimeout(timeOut);
    }
</script>
<!-- BEGIN JIVOSITE CODE {literal} -->
<script>
    baguetteBox.run('.tz-gallery');
</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-89383715-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-89383715-1');
</script>

</body>
</html>
<?php $this->endPage() ?>

