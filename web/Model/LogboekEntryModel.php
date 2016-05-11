<?php
/**
 * Created by PhpStorm.
 * User: marijn
 * Date: 26-2-16
 * Time: 8:36
 */

namespace Model;


use Helper\Database;

class LogboekEntryModel extends BaseModel
{
    protected $table = 'logboek_entry';

    public function getEntriesByLog($log)
    {
        $logboekModel = new LogboekModel();
        if(is_numeric($log))
        {
//            $log = $logboekModel->getById($log);
            $logId = $log;
        }
        else{
            $logId = $log['id'];
        }

        $criteria = array(
            'where' => array(
                'logboek' => $logId,
                'deleted' => 0
            )
        );
        $result = $this->db->select($this->table, $criteria);

        return $result;
    }


//    public function createEntry($data)
//    {
//        $newEntry = array(
//            'logboek' => $data['logboekId'],
//            'date' => $data['date'],
//        );
//
//        $result =  $this->db->insert($this->table, $newEntry);
//
//        return $result;
//    }
}