<?php
/**
 * Created by PhpStorm.
 * User: marijn
 * Date: 14-2-16
 * Time: 13:40
 */

namespace Helper;

use PDO;
use PDOException;

class Database
{
    const DATABASE_SERVER = 'localhost';
    const DATABASE_SCHEMA = 'organize';
    const DATABASE_USER = 'root';
    const DATABASE_PASS = '';

    const QUERY_ASC = 'ASC';
    const QUERY_DESC = 'DESC';

    const OPERATORS  = array('=', '!=', 'IS', 'IS_NOT', '>', '<', '>=', '<=');

    private $shared;

//    public static function getInstance()
//    {
//        return $this->shared;
//    }
    /**
     * @var PDO
     */
    private $connection;

    public function __construct()
    {
//        error_log( __CLASS__.' ' . __FUNCTION__);
        try {
            $this->connection = new PDO("mysql:host=" . self::DATABASE_SERVER . ";dbname=" . self::DATABASE_SCHEMA, self::DATABASE_USER, self::DATABASE_PASS);
            // set the PDO error mode to exception
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            error_log("DB Connected successfully");
        } catch (PDOException $e) {
            error_log("Connection failed: " . $e->getMessage());
        }
    }

    public function select($table, $pk = null, $query = array())
    {
//        error_log( __CLASS__.' ' . __FUNCTION__);
        if (!$table) {
            throw new \Exception('No Table set');
        }

//        if(empty($pk))
//        {
//            $pk = array('*');
//        }
        //check of elke select uit niet meer dan [column] bestaat of [column as var]
        $select = '';
        if (isset($query['select'])) {
            foreach ($query['select'] as $key => $value) {
                $select .= (strlen($select > 0) ? ', ' : '') . trim($value);
            }
        } else {
            $select = '*';
        }
        $where = null;
        $maxResult = null;
        $orderBy = null;
        if($pk) {
            if (is_array($pk)) {
                if (isset($pk['where'])) {
                    if (!is_array($pk['where'])) {
                        throw new PDOException('"where" needs to be an array.');
                    }
                    $where = '';
                    foreach ($pk['where'] as $key => $value) {
                        $where .= $this->addWhere((strlen($where) > 0) ,$key, $value);
                    }
                }
                if (isset($pk['orderBy'])) {
                    if (!is_array($pk['orderBy'])) {
                        throw new PDOException('"orderBy" needs to be an array.');
                    }
                    $orderBy = '';
                    foreach ($pk['orderBy'] as $key => $value) {
                        if (str_word_count($key) !== 1) {
                            throw new \Exception('Please use one column in the key of an "orderBy" entry.');
                        }
                        if (!($value === self::QUERY_ASC || $value === self::QUERY_DESC)) {
                            throw new PDOException('Please use the given query constants "ASC" or "DESC" as "orderBy" values.');
                        }
                        $orderBy .= (strlen($orderBy > 0) ? ', ' : ' ORDER BY ') . trim($key) . ' ' . trim($value);
                    }
                }
                if(isset($pk['maxResult']))
                {
                    $maxResult = ' LIMIT = '. $maxResult;
                }
            } else {
                $where = ' WHERE id = ' . $pk;
            }
        }
        $query = 'SELECT ' . $select . ' FROM ' . $table .
            ($where ? $where : '') .
            ($orderBy ? $orderBy : '').
            ($maxResult ? $maxResult : '');

        $result = $this->execute($query, true);
        return $result;
    }

    public function insert($table, $data)
    {
        if(!$table)
        {
            throw new PDOException('No table set');
        }
        $keys = '';
        $values = '';
//        foreach($data as $entry)
//        {
            foreach($data as $key=>$value)
            {
                $key = trim($key);
                $value = $this->cleanString($value);
                $keys .= (strlen($keys)  > 0? ', ' : '') . '`'.$key.'`';
                $values .= (strlen($values) > 0? (', ') : ('')) . sprintf(is_numeric($value)? '%s' : '\'%s\'' , $value);
            }
//        }
        $query = 'INSERT INTO '.$table.'('.$keys.') VALUE ('. $values . ')';
        $this->execute($query);
        $result = $this->select($table, $this->connection->lastInsertId());
        return $result;
    }
    public function update($table, $pk, $query)
    {
        if(!$table)
        {
            throw new PDOException('No table set');
        }
        $set = '';
        $where = '';
        if($pk) {
            if (is_array($pk)) {
                $query = $pk;
            }
            else {
                $query['where']['id'] = $pk;
            }
        }
        if (isset($query['where'])) {
            if (!is_array($query['where'])) {
                throw new PDOException('"where" needs to be an array.');
            }
            foreach ($query['where'] as $key => $value) {
                $where .= $this->addWhere((strlen($where) > 0), $key, $value);
            }
        }
        if (!is_array($query['set'])) {
            throw new PDOException('"set" needs to be an array.');
        }
        foreach($query['set'] as $key=>$value)
        {
            $key = trim($key);
            $value = trim($value);

            $set .= (strlen($set) > 0 ? ' AND ' : ' SET '). $key. ' = ' .$value;
        }
        $query = 'UPDATE '.$table.$set.$where;

        return $this->execute($query);

    }

    public function delete($table, $pk, $query)
    {
        if(!$table)
        {
            throw new PDOException('No table set');
        }

        $where = '';
        if($pk) {
            if (is_array($pk)) {
                $query = $pk;
            }
            else {
                $query['where']['id'] = $pk;
            }
        }
        if (isset($query['where'])) {
            if (!is_array($query['where'])) {
                throw new PDOException('"where" needs to be an array.');
            }
            foreach ($query['where'] as $key => $value) {
                $where .= $this->addWhere((strlen($where) > 0), $key, $value);
            }
        }
        //update 'deleted' ?
        //$query = 'DELETE FROM '.$table . ' WHERE id = '. $pk;

//     return $this->execute($query);
        return false;
    }


    private function execute($sQuery, $fetch = false)
    {
        error_log('[QUERY] '. $sQuery);
        try {
            $oStmt = $this->connection->prepare($sQuery);
            $oStmt->execute();
            if($fetch){
                $result = $oStmt->fetchAll();
                return $result;
            }
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw $e;
        }
        return true;
    }


    /**
     * @param boolean $and
     * @param $key
     * @param $value
     * @return string
     */
    private function addWhere($and, $key, $value)
    {
        $value = trim($value);
        $key = trim($key);

        $result = $and ? ' AND ' : ' WHERE ';
        $result .= $key;

        if ($this->countWords($value) === 1) {
            $result .= $value === 'null' ? ' IS ' : ' = ';
            $result .= sprintf(is_numeric($value) || is_null($value)? '%s' : '\'%s\'' , $value);

        }
        elseif ($this->countWords($value) === 2)
        {
            $value = explode(' ', $value);
            if(!in_array($value[0], self::OPERATORS))
            {
                throw new PDOException(sprintf(' "%s" is not avalid operator', $value[0]));
            }
            $value[0] = str_replace('_', ' ', $value[0]);
            $result .= ' '. $value[0]. ' ';
            $result .= $value[1] === 'null' ? $value[1] : '\'' . $value[1] . '\'';
        }
        else {
            error_log($this->countWords($value));
            throw new PDOException('Fix your "where" string');
        }
        return $result;
    }
    private function countWords($string)
    {
        $exploded = explode(' ', $string);
        return count($exploded);
    }


    private function cleanString($string)
    {
        return str_replace("'", "\\'", trim($string));
    }
}