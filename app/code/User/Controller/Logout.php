<?php

namespace User\Controller;

use Core\Controller;
use Core\Helper\Auth;
use Core\Helper\Redirect;

/**
 * Class Logout
 * @package User\Controller
 */
class Logout extends Controller
{
    /**
     * Execute
     */
    public function execute()
    {
        // Check that the user is authenticated.
        Auth::checkAuthenticated();

        // Process the logout request, redirecting to the login controller if
        // successful or to the default controller if not.
        if (\User\Model\Login::logout()) {
            Redirect::to("user/login");
        }

        Redirect::to();
    }
}
