<?php
  /*
   * App Core Class
   * Creates URL & loads core controller
   * URL FORMAT - /controller/method/params
   */
class Core {
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';

    public function __construct(){

        $url = $this->getUrl();

        if(isset($url[0]) && file_exists('../app/controllers/'.ucwords($url[0]).'.php' )){
            //If exists, set as controller
            $this->currentController = ucwords($url[0]);
            //Unset 0 Index
            unset($url[0]);
        }

        // Require the controller
        require_once '../app/controllers/'. $this->currentController.'.php';

        // Instantiate controller class
        $this->currentController = new $this->currentController;

        if(isset($url[1])){
            if(method_exists($this->currentController,$url[1])){
                $this->currentMethod= $url[1];
                //Unset 1 index
                unset($url[1]);
            }
        }

        //Get params
        $this->params = $url ? array_values($url):[];

        //Call a callback with array of params
        call_user_func_array([$this->currentController,$this->currentMethod],$this->params);
    }

    public function getUrl(){

        if(isset($_GET['url']))
        {
            $url =explode('/',filter_var(rtrim($_GET['url'],'/'), FILTER_SANITIZE_URL));
            return $url;
        }

    }
}