<?php

namespace User\Controller;

use Core\Controller;
use Core\Helper\Auth;
use Core\Helper\Redirect;
use Exception;

/**
 * Class LoginPost
 * @package User\Controller
 */
class LoginPost extends Controller
{
    /**
     * @throws Exception
     */
    public function execute()
    {
        // Check that the user is unauthenticated.
        Auth::checkUnauthenticated();

        // Process the login request, redirecting to the home controller if
        // successful or back to the login controller if not.
        if (\User\Model\Login::login()) {
            Redirect::to();
        }

        Redirect::to("user/login");
    }
}