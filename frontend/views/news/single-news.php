<?php
/**
 * Created by PhpStorm.
 * User: artur999
 * Date: 10/18/2018
 * Time: 6:10 AM
 */

use common\components\Translate;

$this->title = Translate::text($blog->getLangHasNews(), 'name');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">

    <div class="row ">
        <div class="single-news">
            <div class="col-lg-3">
                <!-- Preview Image -->
                <img width="100%" class="img-fluid rounded" src="/uploads/news/254-223/<?= $blog->image?>" alt="">
                <div class="soc" style="padding-top: 10px">
                    <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
                    <script src="//yastatic.net/share2/share.js"></script>
                    <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,moimir,gplus" data-counter=""></div>
                </div>
            </div>
            <!-- Post Content Column -->
            <div class="col-lg-9">

                <!-- Post Content -->
                <h1 class="lead"><?= Translate::text($blog->getLangHasNews(), 'name');?></h1>

                <?= Translate::text($blog->getLangHasNews(), 'description');?>

            </div>

        </div>

    </div>
    <!-- /.row -->
<br><br>
</div>
