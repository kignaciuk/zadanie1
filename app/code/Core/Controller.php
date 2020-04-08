<?php

namespace Core;

use Core\Helper;

/**
 * Class Controller
 * @package Core
 */
class Controller
{
    /**
     * @var View
     */
    protected $view;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        // Initialize a session.
        Helper\Session::init();

        // If the user is not logged in but a remember cookie exists then
        // attempt to login with cookie. NOTE: We only do this if we are not on
        // the login with cookie controller method (this avoids creating an
        // infinite loop).
        if (Helper\Input::get("url") !== "login/loginWithCookie") {
            $cookie = Helper\Config::get("COOKIE_USER");
            $session = Helper\Config::get("SESSION_USER");

            if (!Helper\Session::exists($session) and Helper\Cookie::exists($cookie)) {
                Helper\Redirect::to(APP_URL . "user/loginWithCookie");
            }
        }

        // Create a new instance of the core view class.
        $this->view = new View;
    }
}
