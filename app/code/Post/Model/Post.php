<?php

namespace Post\Model;

use Core\Model;
use Exception;

/**
 * Class Post
 * @package Post\Model
 */
class Post extends Model
{
    /**
     * @param array $fields
     * @return bool|string
     * @throws Exception
     */
    public function createPost(array $fields)
    {
        if (!$postId = $this->create("posts", $fields)) {
            throw new Exception("There was a problem creating this post!");
        }

        return $postId;
    }

    /**
     * @param $postId
     * @return Post|null
     */
    public static function getInstance($postId)
    {
        $model = new Post();

        if ($model->findPostById($postId)->exists()) {
            return $model;
        }

        return null;
    }

    /**
     * @param $postId
     * @return Post
     */
    public function findPostById($postId)
    {
        return ($this->find("posts", ['id', "=", $postId]));
    }


    /**
     * @param $userId
     * @return array|mixed
     */
    public static function getPostsByUserId($userId)
    {
        $model = new Post();

        return ($model->findAll("posts", ['user_id', "=", $userId]));
    }

    /**
     * @param array $fields
     * @param null $postId
     * @throws Exception
     */
    public function updatePost(array $fields, $postId = null)
    {
        if (!$this->update("posts", $fields, $postId)) {
            throw new Exception("There was a problem updating this post!");
        }
    }

    /**
     * @param null $postId
     * @throws Exception
     */
    public function deletePost($postId = null)
    {
        if (!$this->delete("posts", ['id', '=', $postId])) {
            throw new Exception("There was a problem updating this post!");
        }
    }
}
