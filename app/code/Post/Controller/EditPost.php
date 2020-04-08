<?php

namespace Post\Controller;

use Core\Controller;
use Core\Helper\Auth;
use Core\Helper\Input;
use Core\Helper\Redirect;

/**
 * Class RegisterPost
 * @package User\Controller
 */
class EditPost extends Controller
{
    /**
     * Execute
     */
    public function execute()
    {
        // Check that the user is authenticated.
        Auth::checkAuthenticated();

        // Get post ID.
        $postId = Input::get("id");

        // Process the update request, redirecting to the login controller if
        // successful or back to the register controller if not.
        if (\Post\Model\Edit::update()) {
            Redirect::to();
        }

        Redirect::to(["post/edit", "?id=" . $postId]);
    }
}
