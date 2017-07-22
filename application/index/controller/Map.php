<?php
namespace app\index\Controller;
use think\Controller;

class Map extends Controller{

    public function getImage($data){

        return \Map::staticImage($data);

    }

}