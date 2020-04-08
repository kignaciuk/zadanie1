<?php

namespace Core\Helper;

/**
 * Class Validate
 * @package Core\Helper
 */
class Validate
{
    /**
     * @var Database|null
     */
    private $db;

    /**
     * @var array
     */
    private $errors = [];

    /**
     * @var
     */
    private $passed;

    /**
     * @var null
     */
    private $recordId;

    /**
     * @var array
     */
    private $source = [];

    /**
     * Validate constructor.
     * @param array $source
     * @param null $recordId
     */
    public function __construct(array $source, $recordId = null)
    {
        $this->db = Database::getInstance();
        $this->recordId = $recordId;
        $this->source = $source;
    }

    /**
     * @param $input
     * @param $error
     */
    private function addError($input, $error)
    {
        $this->errors[$input][] = str_replace(['-', '_'], ' ', ucfirst(strtolower($error)));
    }

    /**
     * @param array $inputs
     * @return $this
     */
    public function check(array $inputs)
    {
        $this->errors = [];
        $this->passed = false;

        foreach ($inputs as $input => $rules) {
            if (isset($this->source[$input])) {
                $value = trim($this->source[$input]);
                $this->validate($input, $value, $rules);
            } else {
                $this->addError($input, sprintf("Unable to validate %s!", $input));
            }
        }

        if (empty($this->errors)) {
            $this->passed = true;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function errors()
    {
        return ($this->errors);
    }

    /**
     * @return mixed
     */
    public function passed()
    {
        return ($this->passed);
    }

    /**
     * @param $input
     * @param $value
     * @param array $rules
     */
    private function validate($input, $value, array $rules)
    {
        foreach ($rules as $rule => $ruleValue) {
            if (($rule === "required" and $ruleValue === true) && empty($value)) {
                $this->addError($input, sprintf("%s is required!", $input));
            } elseif (!empty($value)) {
                $methodName = lcfirst(ucwords(strtolower(str_replace(["-", "_"], "", $rule)))) . "Rule";

                if (method_exists($this, $methodName)) {
                    $this->{$methodName}($input, $value, $ruleValue);
                } else {
                    $this->addError($input, sprintf("Unable to validate %s", $input));
                }
            }
        }
    }

    /**
     * @param $input
     * @param $value
     * @param $ruleValue
     */
    protected function filterRule($input, $value, $ruleValue)
    {
        switch ($ruleValue) {
            // Email
            case "email":
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($input, sprintf("%s is not a valid %s", $input, $ruleValue));
                }
                break;
        }
    }

    /**
     * @param $input
     * @param $value
     * @param $ruleValue
     */
    protected function matchesRule($input, $value, $ruleValue)
    {
        if ($value != $this->source[$ruleValue]) {
            $this->addError($input, sprintf("%s must match %s.", $ruleValue, $input));
        }
    }

    /**
     * @param $input
     * @param $value
     * @param $ruleValue
     */
    protected function maxCharactersRule($input, $value, $ruleValue)
    {
        if (strlen($value) > $ruleValue) {
            $this->addError($input, sprintf("%s can only be a maximum of %s characters.", $input, $ruleValue));
        }
    }

    /**
     * @param $input
     * @param $value
     * @param $ruleValue
     */
    protected function minCharactersRule($input, $value, $ruleValue)
    {
        if (strlen($value) < $ruleValue) {
            $this->addError($input, sprintf("%s must be a minimum of %s characters.", $input, $ruleValue));
        }
    }

    /**
     * @param $input
     * @param $value
     * @param $ruleValue
     */
    protected function requiredRule($input, $value, $ruleValue)
    {
        if ($ruleValue === true && empty($value)) {
            $this->addError($input, sprintf("%s is required!", $input));
        }
    }

    /**
     * @param $input
     * @param $value
     * @param $ruleValue
     */
    protected function uniqueRule($input, $value, $ruleValue)
    {
        $check = $this->db->select($ruleValue, [$input, "=", $value]);

        if ($check->count()) {
            if ($this->recordId && $check->first()->id === $this->recordId) {
                return;
            }

            $this->addError($input, sprintf("%s already exists.", $input));
        }
    }
}
