<?php

/**
 * Created by PhpStorm.
 * User: marijn
 * Date: 5-2-16
 * Time: 17:43
 */
namespace Model;


class LogboekModel extends BaseModel
{
    protected $table = 'logboek';

    public function generateLog($log)
    {
        $logBoekEntryModel = new LogboekEntryModel();
        if(!is_array($log))
        {
            $log = $this->getById($log)[0];
        }

//        error_log(print_r($log,true));
        if(isset($log['interval']) && isset($log['interval_type'])) {
//            error_log(__CLASS__. ' '. __FUNCTION__ . ' 1');

            $startDate = new \DateTime();
            $startDate = $startDate->createFromFormat('Y-m-d h:i:s', $log['date_from']);
            $endDate = new \DateTime();
            $endDate = $endDate->createFromFormat('Y-m-d h:i:s', $log['date_to']);
            $dateInterval = new \DateInterval('P'.$log['interval'] . ucfirst(substr($log['interval_type'],0,1)));
            $datePeriod = new \DatePeriod($startDate, $dateInterval, $endDate);
            error_log(print_r($startDate,true). ' ' . print_r($endDate,true) . ' '. print_r($dateInterval,true) );

            foreach($datePeriod as $key=>$date)
            {
                error_log(print_r($date,true));
                $data = array(
                    'name' => 'entry '.$key,
                    'date' => $date->format('Y-m-d'),
                    'logboek' => $log['id'],
                );
                $logBoekEntryModel->create($data);
            }
//            error_log(__CLASS__. ' '. __FUNCTION__ . ' 2');

        }
        return 'yes';
    }
}