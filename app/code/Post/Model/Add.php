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
class Add
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
    public static function add()
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

        try {
            // Insert the new post record into the database, storing the unique
            // ID which will be returned on success.
            $post = new Post;
            $postId = $post->createPost(
                [
                    "title" => Input::post("title"),
                    "description" => Input::post("description"),
                    "is_active" => Input::post("is_active"),
                    "user_id" => $userId
                ]
            );

            // Write all necessary data into the session as the post has been
            // successfully added and return the post unique ID.
            Message::success("Your post has been successfully created!");

            return $postId;
        } catch (Exception $e) {
            Message::error($e->getMessage());
        }

        return false;
    }
}
