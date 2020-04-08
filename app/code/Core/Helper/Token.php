<?php

namespace Core\Helper;

/**
 * Class Token
 * @package Core\Helper
 */
class Token
{
    /**
     * @return mixed|null
     */
    public static function generate()
    {
        $maxTime = 60 * 60 * 24;
        $tokenSession = Config::get("SESSION_TOKEN");
        $token = Session::get($tokenSession);
        $tokenTimeSession = Config::get("SESSION_TOKEN_TIME");
        $tokenTime = Session::get($tokenTimeSession);

        if ($maxTime + $tokenTime <= time() || empty($token)) {
            Session::put($tokenSession, hash('sha256', uniqid(rand(), true)));
            Session::put($tokenTimeSession, time());
        }

        return Session::get($tokenSession);
    }

    /**
     * @param $token
     * @return bool
     */
    public static function check($token)
    {
        return $token === Session::get(Config::get("SESSION_TOKEN")) && !empty($token);
    }

}
