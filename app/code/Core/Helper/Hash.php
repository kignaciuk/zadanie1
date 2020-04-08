<?php

namespace Core\Helper;

/**
 * Class Hash
 * @package Core\Helper
 */
class Hash {

    /**
     * @param $string
     * @param string $salt
     * @return string
     */
    public static function generate($string, $salt = "") {
        return(hash("sha256", $string . $salt));
    }

    /**
     * @param $length
     * @return string
     */
    public static function generateSalt($length) {
        $salt = "";
        $charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789/\\][{}\'\";:?.>,<!@#$%^&*()-_=+|";

        for ($i = 0; $i < $length; $i++) {
            $salt .= $charset[mt_rand(0, strlen($charset) - 1)];
        }

        return $salt;
    }

    /**
     * @return string
     */
    public static function generateUnique() {
        return(self::generate(uniqid()));
    }
}
