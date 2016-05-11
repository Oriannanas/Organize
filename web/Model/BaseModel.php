<?php
/**
 * Created by PhpStorm.
 * User: marijn
 * Date: 5-2-16
 * Time: 17:45
 */

namespace Model;

use Helper\Database;

class BaseModel
{
    protected $db;
    protected $table;

    public function __construct()
    {
        if(!$this->table)
        {
            throw new \Exception('Set a table for your model');
        }
        $this->db = new Database();
    }

    public function getById($id)
    {
        $result = $this->db->select($this->table, $id);
        return $result;
    }

    public function getBy(array $where, $maxResults = null)
    {

        $query['where'] = $where;
        if(is_numeric($maxResults))
        {
            $query['maxResults'] = $maxResults;
        }
        $result = $this->db->select($this->table, $query);
        return $result;
    }

    public function getAll()
    {
        $response = $this->db->select($this->table);

        return $response;
    }


    public function create($data)
    {
        $response[$this->table] =  $this->db->insert($this->table, $data);

        return $response;
    }

    public function remove($id, $hardRemove = false)
    {

        if($hardRemove)
        {
            $response = $this->db->delete($this->table, $id, array());
        }
        else{
            $response = $this->db->update($this->table, $id, array('set'=> array('deleted' => 1)));
        }
        return $response;
    }
}