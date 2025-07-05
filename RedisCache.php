<?php

// Manages Redis connection and caching

class RedisCache
{
    /** @var \Redis */
    private $redis;

    public function __construct()
    {
        $this->redis = new \Redis();
        $this->redis->connect('127.0.0.1', 6379);
    }

    public function get($key)
    {
        return $this->redis->get($key);
    }

    public function set($key, $value, $ttl = 43200)
    {
        return $this->redis->setex($key, $ttl, json_encode($value));
    }

    public function exists($key)
    {
        return $this->redis->exists($key);
    }
}