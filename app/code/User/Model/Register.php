<?php

namespace User\Model;

use Core\Helper\Hash;
use Core\Helper\Input;
use Core\Helper\Message;
use Exception;

/**
 * Class Register
 * @package User\Model
 */
class Register
{
    /**
     * @var array
     */
    private static $inputs = [
        "firstname" => [
            "required" => true,
        ],
        "lastname" => [
            "required" => true,
        ],
        "email" => [
            "filter" => "email",
            "required" => true,
            "unique" => "users",
        ],
        "gender" => [
            "required" => true,
        ],
        "password" => [
            "min_characters" => 6,
            "required" => true,
        ],
        "password_repeat" => [
            "matches" => "password",
            "required" => true,
        ],
    ];

    /**
     * @return bool|string
     */
    public static function register()
    {
        // Validate the register form inputs.
        if (!Input::check($_POST, self::$inputs)) {
            return false;
        }

        try {
            // Generate a salt, which will be applied to the password during hashing process.
            $salt = Hash::generateSalt(32);

            // Insert the new user record into the database, storing the unique
            // ID which will be returned on success.
            $user = new User;
            $userId = $user->createUser(
                [
                    "email" => Input::post("email"),
                    "firstname" => Input::post("firstname"),
                    "lastname" => Input::post("lastname"),
                    "gender" => Input::post("gender"),
                    "password" => Hash::generate(Input::post("password"), $salt),
                    "salt" => $salt
                ]
            );

            // Write all necessary data into the session as the user has been
            // successfully registered and return the user's unique ID.
            Message::success("Your account has been successfully created!");

            return $userId;
        } catch (Exception $e) {
            Message::error($e->getMessage());
        }

        return false;
    }
}
