<?php

namespace Core\Helper;

/**
 * Class Redirect
 * @package Core\Helper
 */
class Redirect
{
    /**
     * @param string $location
     */
    public static function to($location = "")
    {
        if ($location === 404) {
            header('HTTP/1.0 404 Not Found');
            include VIEW_PATH . "core/404.phtml";
        } else {
            header("Location: " . APP_URL . $location);
        }

        exit();
    }
}
