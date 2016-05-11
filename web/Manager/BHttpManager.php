<?php

/**
 * Created by PhpStorm.
 * User: marijn
 * Date: 8-2-16
 * Time: 17:39
 */

namespace Manager;

class BHttpManager
{

    private $_baseUrl;
    private $moduleNameSpace = 'Module';
    private $controllerNameSpace = 'Controller';

    public function __construct()
    {

    }

    public function processRequest()
    {
        $url = $_SERVER['REQUEST_URI'];
        $path = $this->parseUrl($url);

//        spl_autoload_register(function ($class_name) {
//            include ($_SERVER['DOCUMENT_ROOT'].'Controller/'.$class_name . '.php');
//        });

//        include ($_SERVER['DOCUMENT_ROOT'].'Controller/'.$path['controller'] . '.php');

        $controllerPath = 'Controller\\'.$path['controller'];
        $controller = new $controllerPath();

        $controller->init();
        $controller->setParams($path['params']);
        $controller->run($path['action'], $path['params']);

    }
    public function parseUrl($url)
    {
        $result = explode('/', $url);
//        $controller = null;
//        if(class_exists($this->moduleNameSpace.$result[1]))
//        {
//            $module = new $result[1];
//
//        }
//        $response = new $result[1];
        $response['controller'] = (isset($result[1]) && $result[1] !== ''? ucfirst($result[1]) : 'Default').'Controller';
        $response['action'] = 'action'.(isset($result[2])? ucfirst($result[2]) : 'Index');
        $response['params'] = array_slice($result, 2);
        return $response;
    }

    public function redirect($url, $statusCode = 302)
    {
        if (strpos($url, '/') === 0 && strpos($url, '//') !== 0)
            $url = $this->getHost() . $url;
            header('Location: ' . $url, true, $statusCode);
//        $result = mb_split('/', $url);
//
//        foreach($result as $part)
//        {
//            echo $part;
//        }
//        foreach($data as $dataObject)
//        {
//            echo print_r($dataObject,true);
//        }
    }

    private function getHost()
    {
        if ($secure = $this->getIsSecureConnection())
            $http = 'https';
        else
            $http = 'http';

        if (isset($_SERVER['HTTP_HOST']))
            return  $http . '://' . $_SERVER['HTTP_HOST'];
        else
            return $http . '://' . $_SERVER['SERVER_NAME'];
    }

    public function getIsSecureConnection()
    {
        return isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1)
        || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https';
    }


    public function getBaseUrl($absolute = false)
    {
        if ($this->_baseUrl === null)
            $this->_baseUrl = rtrim(dirname($this->getScriptUrl()), '\\/');
        return $absolute ? $this->getHost() . $this->_baseUrl : $this->_baseUrl;
    }

    public function getScriptUrl()
    {
        return $_SERVER[''];
    }
}