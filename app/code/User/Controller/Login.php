<?php

namespace User\Controller;

use Core\Controller;
use Core\Helper\Auth;

/**
 * Class Login
 * @package User\Controller
 */
class Login extends Controller
{
    /**
     * Execute
     */
    public function execute()
    {
        // Check that the user is unauthenticated.
        Auth::checkUnauthenticated();

        // Set any dependencies, data and render the view.
        $this->view->render("user/login", [
            "title" => "Login"
        ]);
    }
}
