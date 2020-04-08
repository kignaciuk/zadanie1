<?php

namespace User\Model;

use Core\Model;
use Exception;

/**
 * Class User
 * @package User\Model
 */
class User extends Model
{
    /**
     * @param array $fields
     * @return bool|string
     * @throws Exception
     */
    public function createUser(array $fields)
    {
        if (!$userId = $this->create("users", $fields)) {
            throw new Exception("There was a problem creating this account!");
        }

        return $userId;
    }

    /**
     * @param $user
     * @return User|null
     */
    public static function getInstance($user)
    {
        $model = new User();

        if ($model->findUser($user)->exists()) {
            return $model;
        }

        return null;
    }

    /**
     * @param $user
     * @return User
     */
    public function findUser($user)
    {
        $field = filter_var($user, FILTER_VALIDATE_EMAIL) ? "email" : "id";

        return ($this->find("users", [$field, "=", $user]));
    }

    /**
     * @param array $fields
     * @param null $userId
     * @throws Exception
     */
    public function updateUser(array $fields, $userId = null)
    {
        if (!$this->update("users", $fields, $userId)) {
            throw new Exception("There was a problem updating this account!");
        }
    }
}