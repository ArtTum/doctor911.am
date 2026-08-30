<?php

namespace common\tests\unit\components;

use yii\web\Request;

class TrustedProxyConfigTest extends \Codeception\Test\Unit
{
    private $serverBackup;

    protected function _before()
    {
        $this->serverBackup = $_SERVER;
        putenv('TRUSTED_PROXY_CIDRS');
    }

    protected function _after()
    {
        $_SERVER = $this->serverBackup;
    }

    public function testCloudflarePeerCanSupplyConnectingIp()
    {
        $_SERVER['REMOTE_ADDR'] = '172.70.240.56';
        $_SERVER['HTTP_CF_CONNECTING_IP'] = '203.0.113.25';

        $request = new Request(require codecept_root_dir() . 'config/trusted-proxies.php');

        $this->assertSame('203.0.113.25', $request->getUserIP());
    }

    public function testUntrustedPeerCannotSpoofConnectingIp()
    {
        $_SERVER['REMOTE_ADDR'] = '198.51.100.10';
        $_SERVER['HTTP_CF_CONNECTING_IP'] = '203.0.113.25';

        $request = new Request(require codecept_root_dir() . 'config/trusted-proxies.php');

        $this->assertSame('198.51.100.10', $request->getUserIP());
    }
}
