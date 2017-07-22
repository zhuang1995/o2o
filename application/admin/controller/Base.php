<?php
namespace app\admin\Controller;
use think\Controller;

class Base extends Controller{

    public function status(){
        $data = input('get.');
        $model = request()->controller();
        $res = model($model)->save($data, ['id'=>intval($data['id'])]);
        if($res){
            $this->success('数据更新成功');
        }else{
            $this->error('数据更新失败');
        }
    }

    public function add(){

    }

}