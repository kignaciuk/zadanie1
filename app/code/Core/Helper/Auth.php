<?php

namespace Core\Helper;

/**
 * Class Auth
 * @package Core\Helper
 */
class Auth {
    /**
     * @param string $redirect
     */
    public static function checkAuthenticated($redirect = "user/login") {
        Session::init();

        if (!Session::exists(Config::get("SESSION_USER"))) {
            Session::destroy();
            Redirect::to($redirect);
        }
    }

    /**
     * @param string $redirect
     */
    public static function checkUnauthenticated($redirect = "") {
        Session::init();

        if (Session::exists(Config::get("SESSION_USER"))) {
            Redirect::to($redirect);
        }
    }
}
