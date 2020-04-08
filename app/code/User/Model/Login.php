<?php

namespace User\Model;

use Core\Helper\Config;
use Core\Helper\Cookie;
use Core\Helper\Database;
use Core\Helper\Hash;
use Core\Helper\Input;
use Core\Helper\Message;
use Core\Helper\Session;
use Exception;

/**
 * Class Login
 * @package User\Model
 */
class Login
{
    /**
     * @var array
     */
    private static $inputs = [
        "email" => [
            "filter" => "email",
            "required" => true,
        ],
        "password" => [
            "required" => true,
        ],
    ];

    /**
     * @param $userId
     * @return bool
     */
    public static function createRememberCookie($userId)
    {
        $db = Database::getInstance();
        $check = $db->select("user_cookies", ["user_id", "=", $userId]);

        if ($check->count()) {
            $hash = $check->first()->hash;
        } else {
            $hash = Hash::generateUnique();

            if (!$db->insert("user_cookies", ["user_id" => $userId, "hash" => $hash])) {
                return false;
            }
        }
        
        $cookie = Config::get("COOKIE_USER");
        $expiry = Config::get("COOKIE_DEFAULT_EXPIRY");

        return (Cookie::put($cookie, $hash, $expiry));
    }

    /**
     * @return bool
     */
    public static function login()
    {
        // Validate the login form inputs.
        if (!Input::check($_POST, self::$inputs)) {
            return false;
        }

        // Check if the user exists.
        $email = Input::post("email");
        
        if (!$user = User::getInstance($email)) {
            Message::notice("User not found!");

            return false;
        }
        
        try {
            $data = $user->data();

            // Check if the provided password fits the hashed password in the
            // database.
            $password = Input::post("password");

            if (Hash::generate($password, $data->salt) !== $data->password) {
                throw new Exception("Invalid login or password");
            }

            // Create a remember me cookie if the user has selected the option
            // to remained logged in on the login form.
            $remember = Input::post("remember") === "on";
            
            if ($remember && !self::createRememberCookie($data->id)) {
                throw new Exception();
            }

            // Write all necessary data into the session as the login has been
            // successful.
            Session::put(Config::get("SESSION_USER"), $data->id);

            return true;
        } catch (Exception $e) {
            Message::warning($e->getMessage());
        }

        return false;
    }

    /**
     * @return bool
     */
    public static function loginWithCookie()
    {
        // Check if a remember me cookie exists.
        if (!Cookie::exists(Config::get("COOKIE_USER"))) {
            return false;
        }

        // Check if the hash exists in the database, grabbing the ID of the user
        // it is attached to it if it does.
        $db = Database::getInstance();
        $hash = Cookie::get(Config::get("COOKIE_USER"));
        $check = $db->select("user_cookies", ["hash", "=", $hash]);

        if ($check->count()) {
            // Check if the user exists.
            $userId = $db->first()->user_id;
            
            if (($user = User::getInstance($userId))) {
                $data = $user->data();
                Session::put(Config::get("SESSION_USER"), $data->id);

                return true;
            }
        }

        Cookie::delete(Config::get("COOKIE_USER"));

        return false;
    }

    /**
     * @return bool
     */
    public static function logout()
    {
        // Delete the user remember me cookie if one has been stored.
        $cookie = Config::get("COOKIE_USER");
        
        if (Cookie::exists($cookie)) {
            $db = Database::getInstance();
            $hash = Cookie::get($cookie);
            $check = $db->delete("user_cookies", ["hash", "=", $hash]);

            if ($check->count()) {
                Cookie::delete($cookie);
            }
        }

        // Destroy all data registered to the session.
        Session::destroy();

        return true;
    }
}
