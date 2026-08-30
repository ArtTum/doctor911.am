<?php

use common\components\Translate;
use common\components\Helper;
use yii\helpers\Html;
use common\widgets\Alert;

/* @var $this yii\web\View */

$this->title = Translate::text($home_page->getLangHasPages(), 'meta_title');

$this->registerMetaTag(['name' => 'keywords', 'content' => Translate::text($home_page->getLangHasPages(), 'meta_keys')]);
$this->registerMetaTag(['name' => 'description', 'content' => Translate::text($home_page->getLangHasPages(), 'meta_description')]);

?>
<span style="display: none;" itemprop="description"> Doctor911 սերվիսը հնարավորություն է տալիս գտնել ձեր բժիշկին և գրանցվել նրա մոտ այցելության: Service - bjishkner Erevanum, Hayastanum, bjishkner am online - Doctor911</span>
<span style="display: none;" itemprop="keywords"> bjishkner, bjishkner am, hivandutyunner am, bjishkner hayastanum, bjishkner erevanum, bjishk online, bjshkakan kentronner</span>
<svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
    <defs>
        <symbol id="icon-icon-bottom" viewBox="0 0 20 32">
            <title>icon-bottom</title>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M0.888 21.415c0.187-0.187 0.445-0.302 0.731-0.302 0.571 0 1.034 0.463 1.034 1.034s-0.463 1.034-1.034 1.034c-0.285 0-0.544-0.116-0.731-0.302v0c-0.188-0.187-0.304-0.446-0.304-0.731s0.116-0.544 0.304-0.731l0-0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M3.639 24.17c0.187-0.187 0.446-0.303 0.731-0.303 0.571 0 1.034 0.463 1.034 1.034s-0.463 1.034-1.034 1.034c-0.286 0-0.544-0.116-0.731-0.303v0c-0.187-0.187-0.303-0.445-0.303-0.731s0.116-0.544 0.303-0.731v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M6.391 26.917c0.187-0.187 0.446-0.303 0.731-0.303 0.571 0 1.034 0.463 1.034 1.034s-0.463 1.034-1.034 1.034c-0.286 0-0.544-0.116-0.731-0.303v0c-0.187-0.187-0.303-0.445-0.303-0.731s0.116-0.544 0.303-0.731v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M9.142 29.668c0.187-0.187 0.446-0.303 0.731-0.303 0.571 0 1.034 0.463 1.034 1.034s-0.463 1.034-1.034 1.034c-0.286 0-0.544-0.116-0.731-0.303v0c-0.187-0.187-0.303-0.445-0.303-0.731s0.116-0.544 0.303-0.731v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M18.856 21.415c-0.187-0.187-0.445-0.302-0.731-0.302-0.571 0-1.034 0.463-1.034 1.034s0.463 1.034 1.034 1.034c0.285 0 0.544-0.116 0.731-0.302v0c0.188-0.187 0.304-0.446 0.304-0.731s-0.116-0.544-0.304-0.731l-0-0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M16.106 24.17c-0.187-0.187-0.446-0.303-0.731-0.303-0.571 0-1.034 0.463-1.034 1.034s0.463 1.034 1.034 1.034c0.286 0 0.544-0.116 0.731-0.303v0c0.187-0.187 0.303-0.445 0.303-0.731s-0.116-0.544-0.303-0.731v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M13.354 26.917c-0.187-0.187-0.446-0.303-0.731-0.303-0.571 0-1.034 0.463-1.034 1.034s0.463 1.034 1.034 1.034c0.286 0 0.544-0.116 0.731-0.303v0c0.187-0.187 0.303-0.445 0.303-0.731s-0.116-0.544-0.303-0.731v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M10.603 29.668c-0.187-0.187-0.446-0.303-0.731-0.303-0.571 0-1.034 0.463-1.034 1.034s0.463 1.034 1.034 1.034c0.286 0 0.544-0.116 0.731-0.303v0c0.187-0.187 0.303-0.445 0.303-0.731s-0.116-0.544-0.303-0.731v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M9.872 12.465c0.571 0 1.034 0.463 1.034 1.034s-0.463 1.034-1.034 1.034c-0.569 0-1.031-0.46-1.034-1.029v-0c0-0.001 0-0.003 0-0.005 0-0.571 0.463-1.034 1.034-1.034 0 0 0 0 0 0v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M9.872 16.356c0.571 0 1.034 0.463 1.034 1.034s-0.463 1.034-1.034 1.034c-0.571 0-1.034-0.463-1.034-1.034v0c0-0.571 0.463-1.034 1.034-1.034v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M9.872 20.246c0.571 0 1.034 0.463 1.034 1.034s-0.463 1.034-1.034 1.034c-0.571 0-1.034-0.463-1.034-1.034v0c0-0.571 0.463-1.034 1.034-1.034v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M9.872 24.137c0.571 0 1.034 0.463 1.034 1.034s-0.463 1.034-1.034 1.034c-0.571 0-1.034-0.463-1.034-1.034v0c0-0.571 0.463-1.034 1.034-1.034v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M9.872 0.794c0.571 0 1.034 0.463 1.034 1.034s-0.463 1.034-1.034 1.034c-0.571 0-1.034-0.463-1.034-1.034v0c0-0.571 0.463-1.034 1.034-1.034v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M9.872 4.684c0.571 0 1.034 0.463 1.034 1.034s-0.463 1.034-1.034 1.034c-0.571 0-1.034-0.463-1.034-1.034v0c0-0.571 0.463-1.034 1.034-1.034v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M9.872 8.575c0.571 0 1.034 0.463 1.034 1.034s-0.463 1.034-1.034 1.034c-0.571 0-1.034-0.463-1.034-1.034v0c0-0.571 0.463-1.034 1.034-1.034v0z"></path>
        </symbol>
        <symbol id="icon-icon-radius" viewBox="0 0 15 32">
            <title>icon-radius</title>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M7.043 13.938c-0.14-0.14-0.226-0.332-0.226-0.545 0-0.426 0.345-0.771 0.771-0.771s0.771 0.345 0.771 0.771c0 0.213-0.086 0.406-0.226 0.545v0c-0.139 0.14-0.332 0.226-0.545 0.226s-0.406-0.086-0.545-0.226v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M9.095 11.886c-0.14-0.14-0.226-0.332-0.226-0.545 0-0.426 0.345-0.771 0.771-0.771s0.771 0.345 0.771 0.771c0 0.213-0.086 0.406-0.226 0.545v0c-0.139 0.14-0.332 0.226-0.545 0.226s-0.406-0.086-0.545-0.226v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M11.148 9.834c-0.14-0.14-0.226-0.332-0.226-0.545 0-0.426 0.345-0.771 0.771-0.771s0.771 0.345 0.771 0.771c0 0.213-0.086 0.406-0.226 0.545v0c-0.139 0.14-0.332 0.226-0.545 0.226s-0.406-0.086-0.545-0.226v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M13.2 7.781c-0.139-0.14-0.226-0.332-0.226-0.545 0-0.426 0.345-0.771 0.771-0.771s0.771 0.345 0.771 0.771c0 0.213-0.086 0.406-0.226 0.545v0c-0.14 0.14-0.333 0.226-0.546 0.226s-0.406-0.086-0.546-0.226v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M7.043 0.533c-0.14 0.14-0.226 0.332-0.226 0.545 0 0.426 0.345 0.771 0.771 0.771s0.771-0.345 0.771-0.771c0-0.213-0.086-0.406-0.226-0.545v0c-0.14-0.139-0.332-0.226-0.545-0.226s-0.406 0.086-0.545 0.226v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M9.095 2.586c-0.14 0.14-0.226 0.332-0.226 0.545 0 0.426 0.345 0.771 0.771 0.771s0.771-0.345 0.771-0.771c0-0.213-0.086-0.406-0.226-0.545v0c-0.139-0.14-0.332-0.226-0.545-0.226s-0.406 0.086-0.545 0.226v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M11.148 4.638c-0.14 0.14-0.226 0.332-0.226 0.545 0 0.426 0.345 0.771 0.771 0.771s0.771-0.345 0.771-0.771c0-0.213-0.086-0.406-0.226-0.545v0c-0.139-0.14-0.332-0.226-0.545-0.226s-0.406 0.086-0.545 0.226v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M13.2 6.688c-0.139 0.14-0.226 0.332-0.226 0.545 0 0.426 0.345 0.771 0.771 0.771s0.771-0.345 0.771-0.771c0-0.213-0.086-0.406-0.226-0.545v0c-0.14-0.14-0.333-0.226-0.546-0.226s-0.406 0.086-0.546 0.226v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M3.217 12.796c-0.426 0-0.771-0.345-0.771-0.771s0.345-0.771 0.771-0.771c0.425 0 0.769 0.343 0.771 0.768v0c0 0.001 0 0.002 0 0.003 0 0.426-0.345 0.771-0.771 0.771 0 0 0 0 0 0v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M4.825 10.147c-0.426 0-0.771-0.345-0.771-0.771s0.345-0.771 0.771-0.771c0.426 0 0.771 0.345 0.771 0.771v0c0 0.426-0.345 0.771-0.771 0.771v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M7.111 8.345c-0.426 0-0.771-0.345-0.771-0.771s0.345-0.771 0.771-0.771c0.426 0 0.771 0.345 0.771 0.771v0c0 0.426-0.345 0.771-0.771 0.771v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M9.073 7.236c0-0.426 0.345-0.771 0.771-0.771s0.771 0.345 0.771 0.771c0 0.426-0.345 0.771-0.771 0.771v0c-0.426 0-0.771-0.345-0.771-0.771v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M4.317 21.587c-0.426 0-0.771-0.345-0.771-0.771s0.345-0.771 0.771-0.771c0.426 0 0.771 0.345 0.771 0.771v0c0 0.426-0.345 0.771-0.771 0.771v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M5.587 24.212c-0.426 0-0.771-0.345-0.771-0.771s0.345-0.771 0.771-0.771c0.426 0 0.771 0.345 0.771 0.771v0c0 0.426-0.345 0.771-0.771 0.771v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M6.349 26.836c-0.426 0-0.771-0.345-0.771-0.771s0.345-0.771 0.771-0.771c0.426 0 0.771 0.345 0.771 0.771v0c0 0.426-0.345 0.771-0.771 0.771v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M6.434 29.376c-0.426 0-0.771-0.345-0.771-0.771s0.345-0.771 0.771-0.771c0.426 0 0.771 0.345 0.771 0.771v0c0 0.426-0.345 0.771-0.771 0.771v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M6.434 31.746c-0.426 0-0.771-0.345-0.771-0.771s0.345-0.771 0.771-0.771c0.426 0 0.771 0.345 0.771 0.771v0c0 0.426-0.345 0.771-0.771 0.771v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M2.709 18.939c-0.426 0-0.771-0.345-0.771-0.771s0.345-0.771 0.771-0.771c0.426 0 0.771 0.345 0.771 0.771v0c0 0.426-0.345 0.771-0.771 0.771v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M2.709 15.867c-0.426 0-0.771-0.345-0.771-0.771s0.345-0.771 0.771-0.771c0.426 0 0.771 0.345 0.771 0.771v0c0 0.426-0.345 0.771-0.771 0.771v0z"></path>
        </symbol>
        <symbol id="icon-icon-right" viewBox="0 0 52 32">
            <title>icon-right</title>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M34.523 1.624c-0.303 0.303-0.49 0.722-0.49 1.184 0 0.925 0.75 1.675 1.675 1.675s1.675-0.75 1.675-1.675c0-0.462-0.187-0.881-0.49-1.184v0c-0.303-0.304-0.722-0.492-1.185-0.492s-0.882 0.188-1.185 0.492l-0 0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M38.989 6.082c-0.303 0.303-0.491 0.722-0.491 1.185 0 0.925 0.75 1.675 1.675 1.675s1.675-0.75 1.675-1.675c0-0.463-0.188-0.882-0.491-1.185v0c-0.303-0.303-0.722-0.49-1.184-0.49s-0.881 0.187-1.184 0.49v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M43.441 10.542c-0.303 0.303-0.491 0.722-0.491 1.185 0 0.925 0.75 1.675 1.675 1.675s1.675-0.75 1.675-1.675c0-0.463-0.188-0.882-0.491-1.185v0c-0.303-0.303-0.722-0.491-1.184-0.491s-0.881 0.188-1.184 0.491l-0 0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M47.899 15c-0.303 0.303-0.491 0.722-0.491 1.185 0 0.925 0.75 1.675 1.675 1.675s1.675-0.75 1.675-1.675c0-0.463-0.188-0.882-0.491-1.185v0c-0.303-0.303-0.722-0.491-1.184-0.491s-0.881 0.188-1.184 0.491l-0 0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M34.523 30.744c-0.303-0.303-0.49-0.722-0.49-1.184 0-0.925 0.75-1.675 1.675-1.675s1.675 0.75 1.675 1.675c0 0.462-0.187 0.881-0.49 1.184v0c-0.303 0.304-0.722 0.492-1.185 0.492s-0.882-0.188-1.185-0.492l-0-0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M38.989 26.286c-0.303-0.303-0.491-0.722-0.491-1.185 0-0.925 0.75-1.675 1.675-1.675s1.675 0.75 1.675 1.675c0 0.463-0.188 0.882-0.491 1.185v0c-0.303 0.303-0.722 0.49-1.184 0.49s-0.881-0.187-1.184-0.49v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M43.441 21.826c-0.303-0.303-0.491-0.722-0.491-1.185 0-0.925 0.75-1.675 1.675-1.675s1.675 0.75 1.675 1.675c0 0.463-0.188 0.882-0.491 1.185v0c-0.303 0.303-0.722 0.491-1.184 0.491s-0.881-0.188-1.184-0.491l-0-0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M47.899 17.368c-0.303-0.303-0.491-0.722-0.491-1.185 0-0.925 0.75-1.675 1.675-1.675s1.675 0.75 1.675 1.675c0 0.463-0.188 0.882-0.491 1.185v0c-0.303 0.303-0.722 0.491-1.184 0.491s-0.881-0.188-1.184-0.491l-0-0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M20.018 16.184c0 0.925 0.75 1.675 1.675 1.675s1.675-0.75 1.675-1.675c0-0.923-0.746-1.671-1.668-1.675h-0c-0.002 0-0.005-0-0.007-0-0.925 0-1.675 0.75-1.675 1.675 0 0 0 0 0 0v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M26.325 16.184c0 0.925 0.75 1.675 1.675 1.675s1.675-0.75 1.675-1.675c0-0.925-0.75-1.675-1.675-1.675v0c-0.925 0-1.675 0.75-1.675 1.675v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M32.629 16.184c0 0.925 0.75 1.675 1.675 1.675s1.675-0.75 1.675-1.675c0-0.925-0.75-1.675-1.675-1.675v0c-0.925 0-1.675 0.75-1.675 1.675v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M38.935 16.184c0 0.925 0.75 1.675 1.675 1.675s1.675-0.75 1.675-1.675c0-0.925-0.75-1.675-1.675-1.675v0c-0.925 0-1.675 0.75-1.675 1.675v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M1.103 16.184c0 0.925 0.75 1.675 1.675 1.675s1.675-0.75 1.675-1.675c0-0.925-0.75-1.675-1.675-1.675v0c-0.925 0-1.675 0.75-1.675 1.675v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M7.408 16.184c0 0.925 0.75 1.675 1.675 1.675s1.675-0.75 1.675-1.675c0-0.925-0.75-1.675-1.675-1.675v0c-0.925 0-1.675 0.75-1.675 1.675v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M13.714 16.184c0 0.925 0.75 1.675 1.675 1.675s1.675-0.75 1.675-1.675c0-0.925-0.75-1.675-1.675-1.675v0c-0.925 0-1.675 0.75-1.675 1.675v0z"></path>
        </symbol>
        <symbol id="icon-icon-left" viewBox="0 0 52 32">
            <title>icon-left</title>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M17.339 30.744c0.303-0.303 0.49-0.722 0.49-1.184 0-0.925-0.75-1.675-1.675-1.675s-1.675 0.75-1.675 1.675c0 0.462 0.187 0.881 0.49 1.184v0c0.303 0.304 0.722 0.492 1.185 0.492s0.882-0.188 1.185-0.492l0-0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M12.874 26.286c0.303-0.303 0.491-0.722 0.491-1.185 0-0.925-0.75-1.675-1.675-1.675s-1.675 0.75-1.675 1.675c0 0.463 0.188 0.882 0.491 1.185v0c0.303 0.303 0.722 0.49 1.184 0.49s0.881-0.187 1.184-0.49v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M8.421 21.826c0.303-0.303 0.491-0.722 0.491-1.185 0-0.925-0.75-1.675-1.675-1.675s-1.675 0.75-1.675 1.675c0 0.463 0.188 0.882 0.491 1.185v0c0.303 0.303 0.722 0.491 1.184 0.491s0.881-0.188 1.184-0.491l0-0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M3.963 17.368c0.303-0.303 0.491-0.722 0.491-1.185 0-0.925-0.75-1.675-1.675-1.675s-1.675 0.75-1.675 1.675c0 0.463 0.188 0.882 0.491 1.185v0c0.303 0.303 0.722 0.491 1.184 0.491s0.881-0.188 1.184-0.491l0-0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M17.339 1.624c0.303 0.303 0.49 0.722 0.49 1.184 0 0.925-0.75 1.675-1.675 1.675s-1.675-0.75-1.675-1.675c0-0.462 0.187-0.881 0.49-1.184v0c0.303-0.304 0.722-0.492 1.185-0.492s0.882 0.188 1.185 0.492l0 0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M12.874 6.082c0.303 0.303 0.491 0.722 0.491 1.185 0 0.925-0.75 1.675-1.675 1.675s-1.675-0.75-1.675-1.675c0-0.463 0.188-0.882 0.491-1.185v0c0.303-0.303 0.722-0.49 1.184-0.49s0.881 0.187 1.184 0.49v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M8.421 10.542c0.303 0.303 0.491 0.722 0.491 1.185 0 0.925-0.75 1.675-1.675 1.675s-1.675-0.75-1.675-1.675c0-0.463 0.188-0.882 0.491-1.185v0c0.303-0.303 0.722-0.491 1.184-0.491s0.881 0.188 1.184 0.491l0 0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M3.963 15c0.303 0.303 0.491 0.722 0.491 1.185 0 0.925-0.75 1.675-1.675 1.675s-1.675-0.75-1.675-1.675c0-0.463 0.188-0.882 0.491-1.185v0c0.303-0.303 0.722-0.491 1.184-0.491s0.881 0.188 1.184 0.491l0 0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M31.844 16.184c0-0.925-0.75-1.675-1.675-1.675s-1.675 0.75-1.675 1.675c0 0.923 0.746 1.671 1.668 1.675h0c0.002 0 0.005 0 0.007 0 0.925 0 1.675-0.75 1.675-1.675 0 0 0 0 0 0v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M25.537 16.184c0-0.925-0.75-1.675-1.675-1.675s-1.675 0.75-1.675 1.675c0 0.925 0.75 1.675 1.675 1.675v0c0.925 0 1.675-0.75 1.675-1.675v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M19.233 16.184c0-0.925-0.75-1.675-1.675-1.675s-1.675 0.75-1.675 1.675c0 0.925 0.75 1.675 1.675 1.675v0c0.925 0 1.675-0.75 1.675-1.675v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M12.927 16.184c0-0.925-0.75-1.675-1.675-1.675s-1.675 0.75-1.675 1.675c0 0.925 0.75 1.675 1.675 1.675v0c0.925 0 1.675-0.75 1.675-1.675v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M50.759 16.184c0-0.925-0.75-1.675-1.675-1.675s-1.675 0.75-1.675 1.675c0 0.925 0.75 1.675 1.675 1.675v0c0.925 0 1.675-0.75 1.675-1.675v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M44.454 16.184c0-0.925-0.75-1.675-1.675-1.675s-1.675 0.75-1.675 1.675c0 0.925 0.75 1.675 1.675 1.675v0c0.925 0 1.675-0.75 1.675-1.675v0z"></path>
            <path fill="#008000" style="fill: var(--color1, #008000)" d="M38.148 16.184c0-0.925-0.75-1.675-1.675-1.675s-1.675 0.75-1.675 1.675c0 0.925 0.75 1.675 1.675 1.675v0c0.925 0 1.675-0.75 1.675-1.675v0z"></path>
        </symbol>
    </defs>
</svg>
<div id="slider">
    <div class="container">
        <?= Alert::widget() ?>
        <div class="slider-text">
            <h1 class="h1-xs"><?= Yii::t('frontend', 'Search for doctors and medical facility')?></h1>
            <a href="<?= Helper::lang($menu->url)?>"><?= Translate::text($menu->getLangHasMenus(), 'name')?></a>
            <p class="info"><?= Yii::t('frontend', 'Go to your doctor and get a 5-40% discount')?></p>
        </div>
        <form id="w0" class="form-search" action="<?= Helper::lang('search')?>" method="post">
            <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
            <input class="search" name="search" type="text" placeholder="<?= Yii::t('frontend', 'Search')?>...">
            <input class="submit" type="submit" value="<?= Yii::t('frontend', 'Search')?>">
            <div class="clear"></div>
        </form>
        <div class="slider-video hidden-xs">
            <!-- Button trigger modal -->

            <a href="" class="video-btn" data-toggle="modal" data-src="/video/doc.mp4" data-target="#myModal">
                <img id="icon-video" width="48px" src="/images/icon-video.png" alt="" class="pull-left">
                <p class="pull-left"><?= Yii::t('frontend', 'How to use?')?><br>
                    <span><?= Yii::t('frontend', 'Watch the video')?></span>
                </p>
            </a>
            <div class="clear"></div>
        </div>

    </div>
</div>
<div id="partner">
    <div class="container">
        <div class="partner-slider">
            <?foreach ($brands as $brand):?>
                <div>
                    <a  style="background-image: url(<?= "/uploads/hospitals/".$brand->image?>)"  class="brand-img" href="<?= Helper::lang($brand->type->alias.'/'.$brand->alias)?>">
                        <? Html::img("/uploads/hospitals/".$brand->image, ['class' => '', 'alt' => 'hospital-img'])?>
                    </a>
                </div>
            <?endforeach;?>

        </div>
    </div>
</div>
<div id="services">
    <div class="container">
        <h3><?= Yii::t('frontend', 'Our Services')?></h3>
        <div class="row">
            <?foreach ($services as $service):?>
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6 nopadding">
                    <div class="service">
                        <a href="<?= Helper::lang('service-doctor/'.$service->alias)?>">
                            <img src="/uploads/categories/45-45/<?= $service->image?>" alt="image">
                            <span class="border"></span>
                            <?= Translate::text($service->getLangHasCategories(), 'name')?>
                        </a>
                    </div>
                </div>
            <?endforeach;?>
        </div>
        <br>
        <p><a class="btn btn-lg btn-success" href="<?= Helper::lang('services')?>"><?= Yii::t('frontend', 'See more')?></a></p>
        <br>
    </div>
</div>
<?if(!empty($help_info)):?>
<div id="info">
    <div class="container">
        <h3><?= Yii::t('frontend', 'How to use our services')?></h3>
        <div class="numbers row">
            <?foreach ($help_info as $k => $info):?>
                <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
                    <div class="same">
                        <img src="uploads/help-info/262-146/<?= $info->image?>" alt="image">
                        <p><?= Translate::text($info->getLangHasHelpInfos(), 'text')?></p>
                    </div>
                </div>
                <?if($k == 0):?>
                    <div class="col-lg-4 col-md-4 col-sm-2 col-xs-12">
                        <div class="same hidden-sm">
                            <span class="right  hidden-lg hidden-md">
                                <svg class="icon icon-icon-bottom"><use xlink:href="#icon-icon-bottom"></use></svg>
                            </span>
                            <span class="horizon hidden-xs hidden-sm">
                                <svg class="icon icon-icon-right"><use xlink:href="#icon-icon-right"></use></svg>
                            </span>
                        </div>
                    </div>
                <?elseif ($k == 1):?>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="same hidden-sm">
                            <span class="right hidden-lg hidden-md">
                                <svg class="icon icon-icon-bottom"><use xlink:href="#icon-icon-bottom"></use></svg>
                            </span>
                            <span class="horizon-buttom hidden-xs hidden-sm">
                                <svg class="icon icon-icon-radius"><use xlink:href="#icon-icon-radius"></use></svg>
                            </span>
                        </div>
                    </div>
                <?elseif ($k == 2):?>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="same hidden-sm">
                            <span class="left">
                                <svg class="icon icon-icon-bottom"><use xlink:href="#icon-icon-bottom"></use></svg>
                            </span>
                        </div>
                    </div>
                <?elseif ($k == 3):?>
                    <div class="col-lg-4 col-md-4 col-sm-2 col-xs-12">
                        <div class="same hidden-sm">
                            <span class="right hidden-lg hidden-md">
                                <svg class="icon icon-icon-bottom"><use xlink:href="#icon-icon-bottom"></use></svg>
                            </span>
                            <span class="horizon hidden-xs hidden-sm">
                                <svg class="icon icon-icon-left"><use xlink:href="#icon-icon-left"></use></svg>
                            </span>
                        </div>
                    </div>
                <?endif;?>
            <?endforeach;?>
        </div>
    </div>
</div>
<?endif;?>
<!-- Modal -->
<div class="modal fade  video-modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <!-- 16:9 aspect ratio -->
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="" id="video"  allowscriptaccess="always"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
