<?php

namespace Post\Controller;

use Core\Controller;
use Core\Helper\Auth;
use Core\Helper\Input;
use Core\Helper\Redirect;

/**
 * Class Delete
 * @package Post\Controller
 */
class Delete extends Controller
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

        \Post\Model\Delete::deletePost($postId);

        Redirect::to();
    }
}
