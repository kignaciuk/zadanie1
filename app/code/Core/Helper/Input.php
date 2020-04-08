<?php

namespace Core\Helper;

/**
 * Class Input
 * @package Core\Helper
 */
class Input
{
    /**
     * @param array $source
     * @param array $inputs
     * @param null $recordId
     * @return bool
     */
    public static function check(array $source, array $inputs, $recordId = null)
    {
        if (!Input::exists()) {
            return false;
        }

        if (!isset($source["csrf_token"]) && !Token::check($source["csrf_token"])) {
            Message::error("Cross-site request forgery verification failed!");

            return false;
        }

        $validate = new Validate($source, $recordId);
        $validation = $validate->check($inputs);

        if (!$validation->passed()) {
            Session::put(Config::get("SESSION_ERRORS"), $validation->errors());

            return false;
        }

        return true;
    }

    /**
     * @param string $source
     * @return bool
     */
    public static function exists($source = "post")
    {
        switch ($source) {
            case 'post':
                return (!empty($_POST));
            case 'get':
                return (!empty($_GET));
        }

        return false;
    }

    /**
     * @param $key
     * @param string $default
     * @return mixed|string
     */
    public static function get($key, $default = "")
    {
        return (isset($_GET[$key]) ? $_GET[$key] : $default);
    }

    /**
     * @param $key
     * @param string $default
     * @return mixed|string
     */
    public static function post($key, $default = "")
    {
        return (isset($_POST[$key]) ? $_POST[$key] : $default);
    }

}