<?php
namespace app\common\Model;
use think\Model;

class Featured extends BaseModel{

    public function getFeaturedsByType($type){
        $data = [
            'type' => $type,
            'status' => ['neq',-1],
        ];
        $order = ['id'=>'desc'];
        return $this->where($data)->order($order)->paginate();
    }
}