<?php

namespace Core;

use Core\Helper\Database;
use Exception;

/**
 * Class Model
 * @package Core
 */
class Model
{
    /**
     * @var Database|null
     */
    protected $db = null;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * Model constructor.
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * @param $table
     * @param array $fields
     * @return bool|string
     */
    protected function create($table, array $fields)
    {
        return ($this->db->insert($table, $fields));
    }

    /**
     * @return array
     */
    public function data()
    {
        return ($this->data);
    }

    /**
     * @return bool
     */
    public function exists()
    {
        return (!empty($this->data));
    }

    /**
     * @param $table
     * @param array $where
     * @return $this
     */
    protected function find($table, array $where = [])
    {
        $data = $this->db->select($table, $where);

        if ($data->count()) {
            $this->data = $data->first();
        }

        return $this;
    }

    /**
     * @param $table
     * @param array $where
     * @return array|mixed
     */
    protected function findAll($table, array $where = [])
    {
        return $this->db->select($table, $where)->results();
    }

    /**
     * @param $table
     * @param array $fields
     * @param null $recordId
     * @return bool
     */
    protected function update($table, array $fields, $recordId = null)
    {
        if (!$recordId && $this->exists()) {
            $recordId = $this->data()->id;
        }

        return ($this->db->update($table, $recordId, $fields));
    }

    /**
     * @param $table
     * @param array $where
     * @return bool
     */
    protected function delete($table, array $where = [])
    {
        return ($this->db->delete($table, $where));
    }
}
