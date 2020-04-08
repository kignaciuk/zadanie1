<?php

namespace Post\Controller;

use Core\Controller;
use Core\Helper\Auth;

/**
 * Class Add
 * @package Post\Controller
 */
class Add extends Controller
{
    /**
     * Execute
     */
    public function execute()
    {
        // Check that the user is authenticated.
        Auth::checkAuthenticated();

        // Set any dependencies, data and render the view.
        $this->view->render("post/add", [
            "title" => "Add Post"
        ]);
    }
}
