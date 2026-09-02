<?php
use backend\assets\AppAsset;
use backend\assets\MetronicAsset;
use yii\bootstrap\Tabs;
use yii\helpers\Html;

if (Yii::$app->controller->action->id === 'login') {
    /**
     * Do not use this code in your template. Remove it.
     * Instead, use the code  $this->layout = '//main-login'; in your controller.
     */
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} else {
if((Yii::$app->controller->action->id == 'index')){
    MetronicAsset::register($this);
}else{
    AppAsset::register($this);
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<!-- begin::Head -->
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!--end::Web font -->
    <!--end::Base Styles -->
    <link rel="shortcut icon" href="<?= Yii::$app->params['app']?>/../favicon.ico" />
    <?php $this->head() ?>
</head>
<!-- end::Head -->
<!-- end::Body -->
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
<?php $this->beginBody() ?>
<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
    <?php if(!Yii::$app->user->isGuest):?>
        <?= $this->render(
            'header.php'
        ) ?>

    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
        <!-- BEGIN: Left Aside -->
        <!-- begin::Body -->
        <?= $this->render(
            'left.php'
        )
        ?>
        <?php endif;?>
        <!-- END: Left Aside -->
        <?= $this->render(
            'content.php',
            ['content' => $content]
        ) ?>

    </div>
    <!-- end:: Body -->
    <!-- begin::Footer -->
    <?= $this->render(
        'footer.php'
    ) ?>
    <div style="display: none;">
        <?= Tabs::widget();?>
    </div>
    <!-- end::Footer -->
</div>
<!-- end:: Page -->
<?php $this->endBody() ?>
</body>
<!-- end::Body -->
</html>
<?php $this->endPage() ?>
<?php } ?>
