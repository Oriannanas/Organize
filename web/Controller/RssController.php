<?php
/**
 * Created by PhpStorm.
 * User: marijn
 * Date: 14-2-16
 * Time: 18:01
 */

namespace Controller;

use Helper\Database;
use Model\LogboekEntryModel;
use Model\LogboekModel;

class RssController extends BaseController
{

    public function actionIndex()
    {
        $now = new \DateTime();

        echo($now->format("Y-m-d H:i:s"));
    }

    public function actionUpdate()
    {
        $db = new Database();
        $logModel = new LogboekModel();
        $logEntryModel = new LogboekEntryModel();

        $response = $logModel->getBy(array('rss_feed' => 'IS_NOT null'));

        $result = array();
        $i = 0;
        $html = '<div class="container">';
        foreach($response as $table) {
            $xml = $table['rss_feed'];
            $result[++$i] = simplexml_load_file($xml);
            $nameArray = preg_match('/(?:.*?searchName=)(.*)/i', $xml);
            $name = str_replace('%A0', ' ', $nameArray[0]);
            $html .= '<h3>'.$name.'</h3>';
            $html .= '<div class="row">';

            http://services.runescape.com/m=adventurers-log/rssfeed?searchName=Fire%A0Mouse
            $entries = $logEntryModel->getBy(array(
                'logboek' => $table['id']
            ), 10);


            $json = json_encode($result[$i]->channel);
            $result[$i] = json_decode($json,TRUE)['item'];
            krsort($result[$i]);
            $response = array();
//            error_log(print_r($result->channel->item,true));
            foreach ($result[$i] as $key => $item) {
                $response[$key]['title'] = (string)$item['title'];
                $response[$key]['description'] = (string)$item['description'];

                $html .= '<div class="col-sm-12">' . $response[$key]['title'] . '<br>' . $response[$key]['description'] . '</div>';

                $itemExtists = false;
                foreach($entries as $entry)
                {
                    if($entry['name'] == trim($response[$key]['title']) && $entry['content'] == trim($response[$key]['description']) && $entry['logboek'] == $table['id'])
                    {
                        $itemExtists = true;
//                        break;
                    }
                }
                if(!$itemExtists)
                {
                    $now = new \DateTime();
                    $logEntryModel->create(array(
                        'logboek' =>  $table['id'],
                        'name' => $response[$key]['title'],
                        'content' => $response[$key]['description'],
                        'date' => $now->format("Y-m-d H:i:s")
                    ));
                }
            }
            $html .= '</div> <br> <br>';



        }
        $html .= '</div>';
        echo $html;
    }
}