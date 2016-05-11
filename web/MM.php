<?php
/**
 * Created by PhpStorm.
 * User: marijn
 * Date: 13-2-16
 * Time: 20:47
 */

require_once($_SERVER['DOCUMENT_ROOT'].'Manager/BHttpManager.php');


class MM
{
    /**
     *
     */

    public $baseUrl;
    public $docRoot;

    /**
     * MM constructor.
     */
//    public function __construct()
//    {
//    }
//
//    /**
//     * Call this method to get singleton
//     *
//     * @return MM
//     */
//    public static function Instance()
//    {
//        static $inst = null;
//        if ($inst === null) {
//            $inst = new MM();
//        }
//        return $inst;
//    }

    public static function Instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new MM();
        }
        return $inst;
    }


    public function __construct()
    {
        $this->docRoot = $_SERVER['DOCUMENT_ROOT'];
//        $this->baseUrl

    }
    public static function start()
    {
        //get controller by
        $bHttp = new \Manager\BHttpManager();
        $bHttp->processRequest();
//        echo $response;
    }

    public static function cronjob($time)
    {
        switch($time)
        {
            case 15:
                $db = new \Helper\Database();
                $response = $db->select('logboek', array(
                    'where' => array('rss_feed' => '!null')
                ));
                $db->insert('logboek_entries',array(

                ));
                break;
        }


    }

    public static function autoload($class)
    {
        // Correct DIRECTORY_SEPARATOR
        $class = str_replace( array( '\\', '/' ), DIRECTORY_SEPARATOR, __DIR__.DIRECTORY_SEPARATOR.$class.'.php' );
        // Get file real path
        if( false === ( $class = realpath( $class ) ) ) {
            // File not found
            return false;
        } else {
            require_once( $class );
            return true;
        }
    }
//    public static function getBaseUrl()
//    {
//        return self::baseUrl;
//    }


}
spl_autoload_register(array('MM','autoload'));