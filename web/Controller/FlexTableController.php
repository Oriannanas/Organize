<?php
/**
 * Created by PhpStorm.
 * User: marijn
 * Date: 14-3-16
 * Time: 17:56
 */

namespace Controller;


use Model\FlexTableModel;

class FlexTableController
{
    public function actionIndex()
    {

    }

    public function actionCreattest()
    {
        $flexTableModel = new FlexTableModel();
        $flexTableModel->create(
          array(
             'field_set'
          ));
    }
}