<?php

class Posts extends Controller {

    public function __construct(){

    }

    public function index(){
        
    }

    public function about($param = null){
        echo "about method in posts loaded  {$param}";
    }
}