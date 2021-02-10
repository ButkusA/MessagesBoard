<?php
defined('CORE_PATH') or exit('no access');
class Controller{

    public function model($model){
        require_once APP_PATH . DIRECTORY_SEPARATOR .'/models/'. $model . '.php';
        return new $model;
    }
    public function view($view, $data = []){
        require_once APP_PATH . 'views/'. $view . '.php';
    }
}