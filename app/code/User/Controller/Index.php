<?php

namespace User\Controller;

use Core\Controller;
use Core\Helper\Auth;
use Core\Helper\Config;
use Core\Helper\Redirect;
use Core\Helper\Session;
use Post\Model\Post;
use User\Model\User;

/**
 * Class Index
 * @package User\Controller
 */
class Index extends Controller
{
    /**
     * Execute
     */
    public function execute()
    {
        // Check that the user is authenticated.
        Auth::checkAuthenticated();

        // Get an instance of the user model using the ID stored in the session.
        $userId = Session::get(Config::get("SESSION_USER"));

        if (!$user = User::getInstance($userId)) {
            Redirect::to();
        }

        // Set any dependencies, data and render the view.
        $this->view->addCSS("css/index.css");
        $this->view->addJS("js/index.jquery.js");
//        $this->view->render("user/index", ["title" => "Index", "user" => $user->data()]);

        $this->view->renderMultiple(
            ["user/index", "post/list"],
            [
                "title" => "Index", "user" => $user->data(),
                "posts" => Post::getPostsByUserId($userId)
            ]
        );
    }
}