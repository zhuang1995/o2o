<?php
namespace app\common\Model;
use think\Model;

class BisLocation extends BaseModel{

    public function getBisLocationPage($bis_id=0){

        $data = [
            'bis_id' => $bis_id,
        ];
        $order = ['id' => 'desc'];
        return $this->where($data)->order($order)->paginate();
    }

    public function getNormalLocationByBisId($bis_id){
        $data = [
            'bis_id' => $bis_id,
            'status' => 1,
        ];
        $order = [
            'id' => 'desc',
        ];
        return $this->where($data)->order($order)->select();

    }

    public function getNormalLocationPoint($id){
        $data = [
            'id' => $id,
            'status' => 1,
        ];
        $order = [
            'id' => 'desc',
        ];
        return $this->where($data)->order($order)->select();
       //return $this->where($data)->field('xponit','yponit')->find();
        /*return Db::table('BisLocation')->field(['xponit','yponit''])->select();*/
    }


    public function getNormalLoationId($id){
        $data = [
            'id' => ['in', $id],
            'status' => 1,
        ];
        $order = ['id'=>'desc'];
        return $this->where($data)->order($order)->select();
    }

}