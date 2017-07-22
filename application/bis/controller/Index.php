<?php
namespace app\bis\Controller;
use think\Controller;

class Index extends Controller{

    public function index(){
        return $this->fetch();
    }

}