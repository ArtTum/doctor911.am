<?php

namespace common\tests\unit\components;

use common\components\SimpleNumericCaptchaAction;
use Yii;
use yii\web\Controller;

class SimpleNumericCaptchaActionTest extends \Codeception\Test\Unit
{
    public function testGeneratesExactlyFourDigits()
    {
        $action = new class('captcha', new Controller('captcha-test', Yii::$app), [
            'width' => 120,
            'height' => 48,
            'padding' => 7,
        ]) extends SimpleNumericCaptchaAction {
            public function generateForTest()
            {
                return $this->generateVerifyCode();
            }

            public function renderForTest($code)
            {
                return $this->renderImage($code);
            }
        };

        for ($i = 0; $i < 25; ++$i) {
            $this->assertMatchesRegularExpression('/^[0-9]{4}$/', $action->generateForTest());
        }

        $image = $action->renderForTest('1234');
        $size = getimagesizefromstring($image);

        $this->assertSame('image/png', $size['mime']);
        $this->assertSame(120, $size[0]);
        $this->assertSame(48, $size[1]);
    }
}
