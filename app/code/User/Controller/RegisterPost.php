<?php

namespace User\Controller;

use Core\Controller;
use Core\Helper\Auth;
use Core\Helper\Redirect;

/**
 * Class RegisterPost
 * @package User\Controller
 */
class RegisterPost extends Controller
{
    /**
     * Execute
     */
    public function execute()
    {
        // Check that the user is unauthenticated.
        Auth::checkUnauthenticated();

        // Process the register request, redirecting to the login controller if
        // successful or back to the register controller if not.
        if (\User\Model\Register::register()) {
            Redirect::to("user/login");
        }

        Redirect::to("user/register");
    }
}
