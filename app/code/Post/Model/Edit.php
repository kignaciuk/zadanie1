<?php

namespace Post\Model;

use Core\Helper\Config;
use Core\Helper\Input;
use Core\Helper\Message;
use Core\Helper\Session;
use Exception;
use User\Model\User;

/**
 * Class Add
 * @package Post\Model
 */
class Edit
{
    /**
     * @var array
     */
    private static $inputs = [
        "title" => [
            "required" => true,
        ],
        "description" => [
            "required" => true,
        ]
    ];

    /**
     * @return bool|string
     */
    public static function update()
    {
        // Validate the add form inputs.
        if (!Input::check($_POST, self::$inputs)) {
            return false;
        }

        // Get an instance of the user model using the ID stored in the session.
        $userId = Session::get(Config::get("SESSION_USER"));

        if (!$user = User::getInstance($userId)) {
            return false;
        }

        // Get post ID.
        $postId = Input::get("id");

        if (!$post = Post::getInstance($postId)) {
            return false;
        }

        if ($post->data()->user_id !== $userId) {
            return false;
        }

        try {
            // Update the post record into the database.
            $post->updatePost(
                [
                    "title" => Input::post("title"),
                    "description" => Input::post("description"),
                    "is_active" => Input::post("is_active"),
                ]
            );

            Message::success("Your post has been successfully updated!");

            return true;
        } catch (Exception $e) {
            Message::error($e->getMessage());
        }

        return false;
    }
}
