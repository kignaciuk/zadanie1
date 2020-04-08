<?php

namespace Core\Helper;

/**
 * Class Cookie
 * @package Core\Helper
 */
class Cookie
{
    /**
     * @param $key
     */
    public static function delete($key)
    {
        self::put($key, "", time() - 1);
    }

    /**
     * @param $key
     * @return bool
     */
    public static function exists($key)
    {
        return (isset($_COOKIE[$key]));
    }

    /**
     * @param $key
     * @return mixed
     */
    public static function get($key)
    {
        return ($_COOKIE[$key]);
    }

    /**
     * @param $key
     * @param $value
     * @param $expiry
     * @return bool
     */
    public static function put($key, $value, $expiry)
    {
        return (setcookie($key, $value, time() + $expiry, "/"));
    }
}
