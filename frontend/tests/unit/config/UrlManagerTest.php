<?php

namespace frontend\tests\unit\config;

use Yii;
use yii\web\Request;

class UrlManagerTest extends \Codeception\Test\Unit
{
    public function testCaptchaRouteTakesPriorityOverHospitalCatchAllRoute()
    {
        $request = new Request();
        $request->setPathInfo('captcha');

        [$route, $params] = Yii::$app->urlManager->parseRequest($request);

        $this->assertSame('site/captcha', $route);
        $this->assertSame([], $params);
    }
}
