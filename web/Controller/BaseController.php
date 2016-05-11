<?php

/**
 * Created by PhpStorm.
 * User: marijn
 * Date: 5-2-16
 * Time: 17:39
 */
//use Managers\UrlManager;

namespace Controller;
class BaseController
{
    protected $_params;
    public $scriptList = array();
    public $cssList = array();

    private $defaultLayout = 'default';

    public function __construct()
    {
    }

    public function init()
    {
    }

    public function run($action, $params = array())
    {
        $this->$action();
        $this->_params = $params;
    }

    protected function render($file, $layout = null, $data = null)
    {
        $layoutPath = $this->parseLayoutPath($layout);
        $filePath = $this->parseTemplatePath($file);

        $content = $this->renderInternal($filePath, $data, true);

        //error_log(print_r($content,true));
        $layoutData = array(
            'content' => $content,
//            'scripts' => implode(\MM::Instance()->getJSScripts())
        );
//        echo $layoutPath;
        $this->renderInternal($layoutPath, $layoutData);
    }

    protected function renderPartial($file, $data = null, $extension = 'php')
    {
        $filePath = \MM::Instance()->docRoot.'View/template/'.$file.'.'.$extension;
        echo $this->renderInternal($filePath, $data, true);
    }

    private  function renderInternal($_viewFile_,$_data_=null,$_return_=false)
    {
        // we use special variable names here to avoid conflict when extracting data
        if(is_array($_data_))
        {
            $scripts = '';
            $csss = '';
            foreach ($this->scriptList as $script)
            {
                $scripts.= $this->renderJs($script);
            }
            foreach ($this->cssList as $css)
            {
                $csss.= $this->renderJs($css);
            }
            $_data_['scripts'] = $scripts;
            $_data_['css'] = $csss;
            extract($_data_,EXTR_PREFIX_SAME,'data');
        }
        else
            $data=$_data_;
        if($_return_)
        {
            ob_start();
            ob_implicit_flush(false);
            require($_viewFile_);
            return ob_get_clean();
        }
        else
        {
            require($_viewFile_);
        }
    }

    public function setParams($params)
    {
        $this->_params = $params;
//        error_log(print_r($params,true));
    }

    /**
     * @param $var
     * @return null
     */
    public function postOrSession($var)
    {
        if(!empty($_POST[$var])) {
            $_SESSION[$var] = $_POST[$var];
        }
        return !empty($_SESSION[$var]) ? $_SESSION[$var] : null;

    }

    private function parseTemplatePath($file)
    {
        return \MM::Instance()->docRoot.'View/template/'.$file.'.php';
    }
    private function parseLayoutPath($layout)
    {
        return \MM::Instance()->docRoot.'View/layout/'.($layout?$layout:$this->defaultLayout).'.php';
    }


    public function addJs($js)
    {
        array_push($this->scriptList, $js);
    }
    public function addCss($css)
    {
        array_push($this->cssList, $css);
    }
    public function renderJs($js)
    {
        return '<script src="/View/js/'.$js.'.js"></script>';
    }
    public function renderCss($css)
    {
        return '<link rel="stylesheet" href="/View/css/'.$css.'.css"/>';
    }
}