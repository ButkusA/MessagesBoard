<?php
defined('CORE_PATH') or exit('no access');
class App {
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];
    public function __construct()
    {
        $url = $this->parseUrl();
        if ($url != null) {

            if (file_exists( APP_PATH . '/controllers/' . $url[0] . '.php')) {
                $this->controller = ucfirst($url[0]);
                unset($url[0]);
            }
        }
        require_once (APP_PATH . 'controllers/' . $this->controller . '.php');
        $this->controller = new $this->controller;
       if(isset ($url[1])){
           if(method_exists($this->controller, $url[1])){
               $this->method = ucfirst($url[1]);
               unset($url[1]);
           }
       }
       $this->params = $url ? array_values($url) : [];
       call_user_func_array([$this->controller, $this->method], $this->params);
    }

    /**
     * @return array
     */
    protected function parseUrl(){

        if (isset($_GET["url"])){
            return $url = explode('/', filter_var(rtrim($_GET["url"], '/'), FILTER_SANITIZE_URL));

        }
    }
}