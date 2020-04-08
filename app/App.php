<?php

use Core\Helper\Input;
use Core\Helper\Redirect;

class App
{
    /**
     * @var array
     */
    private $params;

    /**
     * @var string
     */
    private $class = '\User\Controller\Index';

    public function __construct()
    {
        $this->parseURL();

        try {
            $this->getClass();
            $this->getParams();
        } catch (Exception $e) {
            Redirect::to(404);
        }
    }

    public function run()
    {
        call_user_func_array([$this->class, 'execute'], $this->params);
    }

    private function parseURL()
    {
        if (($url = Input::get("url"))) {
            $this->params = explode("/", filter_var(rtrim($url, "/"), FILTER_SANITIZE_URL));
        }
    }

    private function getClass()
    {
        if (isset($this->params[0]) && isset($this->params[1])) {
            $this->class = '\\' . ucfirst(($this->params[0]) . '\Controller\\' . ucfirst($this->params[1]));
            unset($this->params[0]);
            unset($this->params[1]);
        }

        if (!class_exists($this->class)) {
            throw new Exception("The controller class {$this->class} does not exist!");
        }

        $this->class = new $this->class;
    }

    private function getParams()
    {
        $this->params = $this->params ? array_values($this->params) : [];
    }
}
