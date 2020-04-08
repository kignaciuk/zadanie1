<?php

namespace Post\Model;

use Core\Helper\Config;
use Core\Helper\Message;
use Core\Helper\Session;
use User\Model\User;

/**
 * Class Delete
 * @package Post\Model
 */
class Delete
{
    /**
     * @param $postId
     * @return bool
     */
    public static function deletePost($postId)
    {
        // Get an instance of the user model using the ID stored in the session.
        $userId = Session::get(Config::get("SESSION_USER"));

        if (!$user = User::getInstance($userId)) {
            return false;
        }

        if (!$post = Post::getInstance($postId)) {
            return false;
        }

        if ($post->data()->user_id !== $userId) {
            return false;
        }

        try {
            $post->deletePost($postId);
            Message::success("Your post has been successfully deleted!");

            return true;
        } catch (\Exception $e) {
            Message::error($e->getMessage());
        }

        return false;
    }
}
