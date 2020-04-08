<?php

require_once "../vendor/autoload.php";

// Config
define("ROOT", realpath(dirname(__FILE__) . "/../") . "/");

// App Config
define("APP_NAME", "Blog");
define("APP_ROOT", ROOT . "");
define("APP_PROTOCOL", stripos($_SERVER["SERVER_PROTOCOL"], "https") === true ? "https://" : "http://");
define("APP_URL", APP_PROTOCOL . $_SERVER["HTTP_HOST"] . str_replace("pub", "", dirname($_SERVER["SCRIPT_NAME"])));
define("APP_CONFIG_FILE", APP_ROOT . "etc/config.php");

// Public Config
define("PUB_ROOT", ROOT . "pub/");

// View Config
define("VIEW_PATH", APP_ROOT . 'design/');
