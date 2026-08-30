<?php

namespace common\tests\unit\components;

use common\components\IpRateLimit;
use yii\caching\ArrayCache;

class IpRateLimitTest extends \Codeception\Test\Unit
{
    public function testAllowanceIsStoredPerClient()
    {
        $cache = new ArrayCache();
        $first = new IpRateLimit([
            'id' => '192.0.2.1',
            'limit' => 10,
            'window' => 600,
            'cache' => $cache,
        ]);
        $second = new IpRateLimit([
            'id' => '192.0.2.2',
            'limit' => 10,
            'window' => 600,
            'cache' => $cache,
        ]);

        $first->saveAllowance(null, null, 4, 123456);

        $this->assertSame([4, 123456], $first->loadAllowance(null, null));
        $this->assertSame(10, $second->loadAllowance(null, null)[0]);
    }
}
