<?php
/**
 * Created by PhpStorm.
 * User: marijn
 * Date: 13-2-16
 * Time: 22:36
 */

namespace Controller;

class DefaultController extends BaseController
{


    public function actionIndex(){
    }


    public function actionSapperdeflap(){
        $data = array('param1' => 'sapper', 'param2' => 'de', 'param3' => 'flap');
        $this->render('base', $data);
    }

}