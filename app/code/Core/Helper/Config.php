<?php

namespace Core\Helper;

/**
 * Class Config
 * @package Core\Helper
 */
class Config
{
    /**
     * @var array
     */
    private static $config = [];

    /**
     * @param $key
     * @return mixed|null
     */
    public static function get($key)
    {
        if (empty(self::$config)) {
            self::$config = require_once APP_CONFIG_FILE;
        }

        return (array_key_exists($key, self::$config) ? self::$config[$key] : null);
    }
}