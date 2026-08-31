<?php

namespace common\components;

use yii\captcha\CaptchaAction;

/**
 * A readable four-digit CAPTCHA for the public appointment form.
 */
class SimpleNumericCaptchaAction extends CaptchaAction
{
    /**
     * {@inheritdoc}
     */
    protected function generateVerifyCode()
    {
        return (string) random_int(1000, 9999);
    }

    /**
     * Renders large, upright digits without visual noise.
     *
     * {@inheritdoc}
     */
    protected function renderImage($code)
    {
        if (!function_exists('imagecreatetruecolor') || !function_exists('imagestring')) {
            return parent::renderImage($code);
        }

        $image = imagecreatetruecolor($this->width, $this->height);
        $backColor = $this->allocateColor($image, $this->backColor);
        $foreColor = $this->allocateColor($image, $this->foreColor);
        imagefilledrectangle($image, 0, 0, $this->width - 1, $this->height - 1, $backColor);

        $font = 5;
        $sourceWidth = imagefontwidth($font) * strlen($code);
        $sourceHeight = imagefontheight($font);
        $source = imagecreatetruecolor($sourceWidth, $sourceHeight);
        $sourceBackColor = $this->allocateColor($source, $this->backColor);
        $sourceForeColor = $this->allocateColor($source, $this->foreColor);
        imagefilledrectangle($source, 0, 0, $sourceWidth - 1, $sourceHeight - 1, $sourceBackColor);
        imagestring($source, $font, 0, 0, $code, $sourceForeColor);

        $availableWidth = max(1, $this->width - ($this->padding * 2));
        $availableHeight = max(1, $this->height - ($this->padding * 2));
        $scale = min($availableWidth / $sourceWidth, $availableHeight / $sourceHeight);
        $targetWidth = (int) floor($sourceWidth * $scale);
        $targetHeight = (int) floor($sourceHeight * $scale);
        $targetX = (int) floor(($this->width - $targetWidth) / 2);
        $targetY = (int) floor(($this->height - $targetHeight) / 2);

        imagecopyresized(
            $image,
            $source,
            $targetX,
            $targetY,
            0,
            0,
            $targetWidth,
            $targetHeight,
            $sourceWidth,
            $sourceHeight
        );

        ob_start();
        imagepng($image);
        $contents = ob_get_clean();

        if (PHP_VERSION_ID < 80000) {
            imagedestroy($source);
            imagedestroy($image);
        }

        return $contents;
    }

    /**
     * @param resource|\GdImage $image
     * @param int $color
     * @return int
     */
    private function allocateColor($image, $color)
    {
        return imagecolorallocate(
            $image,
            (int) ($color % 0x1000000 / 0x10000),
            (int) ($color % 0x10000 / 0x100),
            $color % 0x100
        );
    }
}
