<?php

namespace Core\Helper;

/**
 * Class Message
 * @package Core\Helper
 */
class Message
{
    /**
     * @param $key
     * @param string $value
     * @return string|null
     */
    public static function session($key, $value = "")
    {
        if (Session::exists($key)) {
            $session = Session::get($key);
            Session::delete($key);

            return $session;
        } elseif (!empty($value)) {
            return (Session::put($key, $value));
        }

        return null;
    }

    /**
     * @param string $value
     * @return string|null
     */
    public static function error($value = "")
    {
        return (self::session(Config::get("SESSION_MESSAGE_ERROR"), $value));
    }

    /**
     * @param string $value
     * @return string|null
     */
    public static function notice($value = "")
    {
        return (self::session(Config::get("SESSION_MESSAGE_NOTICE"), $value));
    }

    /**
     * @param string $value
     * @return string|null
     */
    public static function success($value = "")
    {
        return (self::session(Config::get("SESSION_MESSAGE_SUCCESS"), $value));
    }

    /**
     * @param string $value
     * @return string|null
     */
    public static function warning($value = "")
    {
        return (self::session(Config::get("SESSION_MESSAGE_WARNING"), $value));
    }
}
