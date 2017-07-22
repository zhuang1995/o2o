<?php
namespace app\common\Model;
use think\Model;

class User extends BaseModel{

    public function add($data) {
        $data['status'] = 1;
        $this->allowField(true)->save($data);
        return $this->id;
    }

    public function getUserByUsername($username){
        if(!$username){
            exception('用户名不合法');
        }
        $data = [
            'username' => $username,
        ];
        return $this->where($data)->find();
    }

}