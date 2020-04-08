<?php

namespace Post\Controller;

use Core\Controller;
use Core\Helper\Auth;
use Core\Helper\Redirect;

/**
 * Class RegisterPost
 * @package User\Controller
 */
class AddPost extends Controller
{
    /**
     * Execute
     */
    public function execute()
    {
        // Check that the user is authenticated.
        Auth::checkAuthenticated();

        if (\Post\Model\Add::add()) {
            Redirect::to();
        }

        Redirect::to("post/add");
    }
}
