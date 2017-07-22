<?php
namespace app\common\Model;
use think\Model;

class Bis extends BaseModel {

    public function getBisStatus($status=0){

        $data = [
            'status' => $status,
        ];
        $order = [
            'id' => 'desc',
        ];
        return $this->where($data)->order($order)->paginate();
    }


    public function saveBisStatus($data=[]){
        $data = [

        ];
        $res = $this->obj->save($data, ['id'=>intval($data['id'])]);
        if($res){
            $this->success('数据更新成功');
        }else{
            $this->error('数据更新失败');
        }

    }





}