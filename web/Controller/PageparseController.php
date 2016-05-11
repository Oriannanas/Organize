<?php
/**
 * Created by PhpStorm.
 * User: marijn
 * Date: 14-3-16
 * Time: 8:25
 */

namespace Controller;


class PageparseController extends BaseController
{

    const SESSION_PAGE_PARSER = 'page_parser';

    public function actionIndex()
    {
        $this->render('page_parse/main');
    }
    public function actionGo()
    {
        $url = $_SESSION['url'];
        $contentId = !empty($_SESSION['contentId'])?$_SESSION['contentId']:null;
        $contentTag = !empty($_SESSION['contentTag'])?$_SESSION['contentTag']:'div';

        $pageContents = file_get_contents($url);

        $regexString = '/.*?<'.$contentTag.'.*?'.($contentId?'id="'.$contentId.'"':'').'.*?>((?:.*?<'.$contentTag.'.*?>.*?</'.$contentTag.'>.*?)*|(?:.*?))</'.$contentTag.'>/';

        $stringOfHope = preg_replace($regexString, '$1 $2', $pageContents);

        $data = array(
            'code' => 200,
            'parseResult' => $stringOfHope
        );
        echo json_encode($data);
        die;
    }

    public function actionUrl()
    {
        if(empty($_POST['url']))
        {
            echo 'Make sure to fill in the url of the page to parse through.';
            die;
        }

        $_SESSION[self::SESSION_PAGE_PARSER]['url'] = $_POST['url'];
        echo json_encode(array('code' => 200));
        die;
    }

    public function actionContentid()
    {
        if(!empty($_POST['contentId'])) {
            $_SESSION[self::SESSION_PAGE_PARSER]['contentId'] = $_POST['contentId'];
        }
        echo json_encode(array('code' => 200));
        die;
    }
    public function actionContenttag()
    {
        if(!empty($_POST['contentTag'])) {
            $_SESSION[self::SESSION_PAGE_PARSER]['contentTag'] = $_POST['contentTag'];
        }
        echo json_encode(array('code' => 200));
        die;
    }
}