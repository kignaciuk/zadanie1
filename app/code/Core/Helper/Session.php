<?php

namespace Core\Helper;

/**
 * Class Session
 * @package Core\Helper
 */
class Session
{
    /**
     * @param $key
     * @return bool
     */
    public static function delete($key)
    {
        if (self::exists($key)) {
            unset($_SESSION[$key]);

            return true;
        }

        return false;
    }

    /**
     * Destroy session
     */
    public static function destroy()
    {
        session_destroy();
    }

    /**
     * @param $key
     * @return bool
     */
    public static function exists($key)
    {
        return (isset($_SESSION[$key]));
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public static function get($key)
    {
        if (self::exists($key)) {
            return ($_SESSION[$key]);
        }

        return null;
    }

    /**
     * Init session
     */
    public static function init()
    {
        // If no session exist, start the session.
        if (session_id() == "") {
            session_start();
        }
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public static function put($key, $value)
    {
        return ($_SESSION[$key] = $value);
    }
}
