<?php

namespace Post\Controller;

use Core\Controller;
use Core\Helper\Auth;
use Core\Helper\Config;
use Core\Helper\Input;
use Core\Helper\Redirect;
use Core\Helper\Session;
use Post\Model\Post;
use User\Model\User;

/**
 * Class Edit
 * @package Post\Controller
 */
class Edit extends Controller
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

        if (!$post = Post::getInstance($postId)) {
            Redirect::to();
        }

        // Get an instance of the user model using the ID stored in the session.
        $userId = Session::get(Config::get("SESSION_USER"));

        if (!$user = User::getInstance($userId)) {
            Redirect::to();
        }

        if ($userId !== $post->data()->user_id) {
            Redirect::to();
        }

        $this->view->render("post/edit", ["title" => "Edit Post", "post" => $post->data()]);
    }
}
