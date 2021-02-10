<?php
    $corePath = 'core';
    $appPath = '../app';

    if(($tmp = realpath($appPath)) !== false){
        $appPath = $tmp . DIRECTORY_SEPARATOR ;
    }

    if(!is_dir($appPath)){
        exit('Your application path conf. is invalid');
    }

    define('APP_PATH', $appPath);

    if (($tmp = realpath(APP_PATH . DIRECTORY_SEPARATOR .$corePath)) !== false){
        $corePath = APP_PATH . $corePath;
    }

    if (!is_dir($corePath)){
        exit('Your core path conf. is invalid');
    }

    define('CORE_PATH', $corePath);
    require_once (APP_PATH . 'init.php');
    $app = new App();