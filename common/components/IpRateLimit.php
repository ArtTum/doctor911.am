<?php

namespace common\components;

use Yii;
use yii\base\BaseObject;
use yii\caching\CacheInterface;
use yii\filters\RateLimitInterface;

/**
 * Cache-backed rate-limit identity for unauthenticated requests.
 */
class IpRateLimit extends BaseObject implements RateLimitInterface
{
    /** @var string Client identifier, normally the address reported by Request::getUserIP(). */
    public $id;

    /** @var int Maximum number of requests in the window. */
    public $limit = 10;

    /** @var int Window size in seconds. */
    public $window = 600;

    /** @var CacheInterface|string Cache component or its application component ID. */
    public $cache = 'cache';

    public function init()
    {
        parent::init();

        if (!is_string($this->id) || $this->id === '') {
            $this->id = 'unknown';
        }

        $this->limit = max(1, (int) $this->limit);
        $this->window = max(1, (int) $this->window);
    }

    public function getRateLimit($request, $action)
    {
        return [$this->limit, $this->window];
    }

    public function loadAllowance($request, $action)
    {
        $value = $this->getCache()->get($this->getCacheKey());

        if (is_array($value)
            && isset($value['allowance'], $value['timestamp'])
            && is_numeric($value['allowance'])
            && is_numeric($value['timestamp'])
        ) {
            return [(int) $value['allowance'], (int) $value['timestamp']];
        }

        return [$this->limit, time()];
    }

    public function saveAllowance($request, $action, $allowance, $timestamp)
    {
        $this->getCache()->set($this->getCacheKey(), [
            'allowance' => max(0, (int) $allowance),
            'timestamp' => (int) $timestamp,
        ], $this->window * 2);
    }

    private function getCache()
    {
        if ($this->cache instanceof CacheInterface) {
            return $this->cache;
        }

        return Yii::$app->get($this->cache);
    }

    private function getCacheKey()
    {
        return [
            __CLASS__,
            hash('sha256', $this->id),
            $this->limit,
            $this->window,
        ];
    }
}
