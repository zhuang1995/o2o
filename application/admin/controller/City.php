<?php
namespace app\admin\Controller;
use think\Controller;
use think\Model;

class City extends Base{


    public function index() {

        $parentId = input('get.parent_id', 0, 'intval');
        $city = Model('city')->getFirstCitys($parentId);
        return $this->fetch('', [
            'city' => $city,
        ]);
    }

    public function add() {

        $city = Model('city')->getNormalCitysByParentId();

        return $this->fetch('', [
            'city'=> $city,
        ]);
    }

    public function save() {

        // print_r(input('post.'));
        //print_r(request()->post());
        if(!request()->isPost()){
            $this->error('提交方式不对');
        }
        $data = input('post.');
        $validate = validate('Base');
        if(!$validate->scene('city')->check($data)) {
            $this->error($validate->getError());
        }
        if(!empty($data['id'])){
            return $this->update($data);
        }

        $res = Model('city')->add($data);
        if($res){
            $this->success('数据插入成功');
        }else{
            $this->error('数据插入失败');
        }
    }

    public function edit(){

        $id = input('get.id');
        if(intval($id) < 1){
            $this->error('参数错误');
        }
        //$id = input('get.id');
        $citys = Model('city')->getNormalCitysByParentId();
        $city = Model('city')->get($id);
        return $this->fetch('', [
            'citys'=> $citys,
            'city'=> $city,
        ]);

    }

    public function update($data){
        $res = Model('city')->save($data, ['id'=>intval($data['id'])]);
        if($res){
            $this->success('数据更新成功');
        }else{
            $this->error('数据更新失败');
        }
    }

}