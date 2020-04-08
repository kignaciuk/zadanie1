<?php

namespace User\Controller;

use Core\Controller;
use Core\Helper\Auth;
use Core\Helper\Redirect;

/**
 * Class LoginWithCookie
 * @package User\Controller
 */
class LoginWithCookie extends Controller
{
    /**
     * Execute
     */
    public function execute()
    {
        // Check that the user is unauthenticated.
        Auth::checkUnauthenticated();

        // Process the login with cookie request, redirecting to the home
        // controller if successful or back to the login controller if not.
        if (\User\Model\Login::loginWithCookie()) {
            Redirect::to();
        }

        Redirect::to("user/login");
    }
}
