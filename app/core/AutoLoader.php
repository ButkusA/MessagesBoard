<?php
defined('CORE_PATH') or exit('no access');
class AutoLoader
{
    public function __construct()
    {
        spl_autoload_register(array($this, 'load'));
        spl_autoload_register(array($this, 'controller'));
        spl_autoload_register(array($this, 'model'));
    }
    //load class by request
    public function load($className, $path = null){
        $path = empty($path)? CORE_PATH : APP_PATH . $path . DIRECTORY_SEPARATOR;
        $filePath = $path . $className . '.php';
        if((file_exists($filePath)) && is_readable($filePath)){
            require_once $filePath;
        }
    }
    //load controllers
    public function controller($className){
        $this->load($className, 'controllers');
    }
    public function model($className){
        $this->load($className, 'models');
    }

}