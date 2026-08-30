<?php
/**
 * Created by PhpStorm.
 * User: Artur
 * Date: 1/24/2017
 * Time: 11:36 PM
 */

use yii\bootstrap\Html;

// \common\components\Helper::out($pagination)
?>

<?if(!empty($pagination)):?>
    <div class="bagination-content">
        <div class="row">
            <?foreach ($pagination as $item):?>
                <?if($item['class'] == 'prev'):?>
                    <div class="col-sm-3 hidden-xs">
                        <a  class="button size-1 style-5" href="<?= $item['url']?>">
                            <span class="button-wrapper">
                                <span class="icon"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
                                <span class="text">Previous</span>
                            </span>
                        </a>
                    </div>

                    <div class="col-sm-6 text-center">
                        <div class="pagination-wrapper">
                            <?endif;?>

                            <?if(($item['class'] != 'prev')):?>
                                <?if($item['class'] != 'next'):?>
                                    <?= Html::a($item['label'], $item['url'], ['class' => $item['active'] ? 'pagination active' : 'pagination'])?>
                                <?endif;?>
                            <?endif;?>


                            <?if($item['class'] == 'next'):?>
                            <?if($pageCount > 5):?>
                                <span class="pagination">...</span>
                                <?= Html::a($pageCount, $afterURL, ['class' => 'pagination'])?>
                            <?endif;?>
                        </div>
                    </div>

                    <div class="col-sm-3 hidden-xs text-right">
                        <a class="button size-1 style-5" href="<?= $item['url']?>">
                            <span class="button-wrapper">
                                <span class="icon"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                                <span class="text">Next</span>
                            </span>
                        </a>
                    </div>
                <?endif;?>
            <?endforeach;?>
        </div>
    </div>
<?endif;?>