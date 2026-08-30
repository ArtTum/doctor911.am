<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/19/2018
 * Time: 4:03 PM
 */
$this->title = 'Հիվանդանոցներ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="row">
        <?for ($i = 1; $i <= 18; $i++):?>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="doctor row">
                    <div class="col-lg-5">
                        <a href="/hospital">
                            <img class="img-doctor " src="/images/new-med.jpg" alt="image">
                        </a>
                    </div>
                    <div class="col-lg-7">
                        <div class="name">
                            <div class="row">
                                <div class="col-lg-8">
                                    <a href="/hospital">
                                        <h6>NEW-MED Ուրոլոգիական կլինիկա</h6>
                                    </a>
                                </div>
                                <div class="col-lg-4">
                                    <div class="sale">
                                        10% - <?= $i?>0%
                                        Զեղչ
                                    </div>
                                </div>
                                <p></p>

                                <div class="col-lg-5">
                                    <?= \yii2mod\rating\StarRating::widget([
                                        'name' => 'input_name',
                                        'value' => 5,
                                        'clientOptions' => [
                                            // Your client options
                                        ],
                                    ]);?>
                                </div>
                                <div class="col-lg-7">
                                    <a class="link" href="#">62 կարծիք</a>
                                </div>
                                <div class="col-lg-12">
                                    <button type="button" class="btn fix-button" data-toggle="modal" data-target="#exampleModal">
                                        Հերթագրվել և ստանալ զեղչ
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <p class="sector">
                            <a href="/hospital">
                                Այս տեսքտը ոչ միայն կարողացել է գոյատևել հինգ դարաշրջան, այլև ներառվել է էլեկտրոնային տպագրության մեջ՝ մնալով էապես անփոփոխ։ Այն հայտնի է դարձել 1960-ականներին։
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        <?endfor;?>

    </div>
</div>

