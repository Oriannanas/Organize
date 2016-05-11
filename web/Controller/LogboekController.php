<?php
namespace Controller;

use Helper\Database;
use Model\LogboekEntryModel;
use Model\LogboekModel;

/**
 * Created by PhpStorm.
 * User: marijn
 * Date: 13-2-16
 * Time: 22:50
 */
class LogboekController extends BaseController
{

    public function actionIndex()
    {
        $this->render('logboek/base');
    }

    public function actionLogs()
    {
        $logModel = new LogboekModel();

        $showDeleted = $this->postOrSession('showdeleted');
        $showHidden = $this->postOrSession('showhidden');

        $response = $logModel->getBy(
            array(
            'deleted' => $showDeleted,
            'hidden' => $showHidden
        ));
        $logboeken = array();
        foreach($response as $logboek)
        {
            $logboeken[$logboek['id']]['id'] = $logboek['id'];
            $logboeken[$logboek['id']]['name'] = $logboek['name'];
            $logboeken[$logboek['id']]['beginDate'] = isset($logboek['date_from'])?$logboek['date_from']: '-';
            $logboeken[$logboek['id']]['endDate'] = isset($logboek['date_to'])?$logboek['date_to']:'-';
        }
        $data = array(
            'logboeken' => $logboeken
        );
        echo json_encode($data);
        die;
    }
    public function actionEntries()
    {
        $entryModel = new LogboekEntryModel();

        $entries = $entryModel->getEntriesByLog($_POST['logId']);

        $data = array(
            'entries' => $entries
        );

        echo json_encode($data);
        die;
    }


    public function actionNew()
    {
        if(!isset($_POST['newLogData']))
        {
            echo 'Fill in the form';
            die;
        }
        $data = $_POST['newLogData'];
        $logModel = new LogboekModel();
        $logData = array(
            'name' => $data['name'],
            'date_from' => date('Y-m-d h:i:s', strtotime($data['dateFrom'])),
            'date_to' => date('Y-m-d h:i:s', strtotime($data['dateTo'])),
            'interval' => $data['interval'],
            'interval_type' => $data['intervalType'],
        );
        $newLog = $logModel->create($logData);

        //generate the log entries the new log deserves
        $response = $logModel->generateLog($newLog);

        echo json_encode($response);
        die;
    }

    public function actionRemove()
    {
        if(!isset($_POST['logId']))
        {
            echo 'what? how? no log selected';
            die;
        }
        $id = $_POST['logId'];

        $logModel = new LogboekModel();

        $response = $logModel->remove($id);

        echo json_encode($response);
        die;
    }
    public function actionGenerate()
    {
        if(!isset($_POST['logId'])){

            echo 'what? how? no log selected';
            die;
        }

        $id = $_POST['logId'];

        $logModel = new LogboekModel();

        $response = $logModel->generateLog($id);

        echo json_encode($response);
        die;

    }
}
