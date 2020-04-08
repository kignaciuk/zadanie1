<?php

namespace User\Controller;

use Core\Helper\Auth;

/**
 * Class Register
 * @package User\Controller
 */
class Register extends \Core\Controller
{
    /**
     * Execute
     */
    public function execute()
    {
        // Check that the user is unauthenticated.
        Auth::checkUnauthenticated();

        // Set any dependencies, data and render the view.
        $this->view->render("user/register", [
            "title" => "Register"
        ]);
    }
}