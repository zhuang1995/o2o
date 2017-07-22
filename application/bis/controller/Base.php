<?php
namespace app\bis\Controller;
use think\Controller;

class Base extends Controller{

    public $account;
    public function _initialize()
    {
        $isLogin = $this->isLogin();
        if(!$isLogin){
            return $this->redirect('login/index');
        }
    }

    public function isLogin(){
        $user = $this->getLoginUser();
        if($user && $user->id){
            return true;
        }else{
            return false;
        }
    }
    /*
     * 登陆
     * */
    public function getLoginUser(){
        if(!$this->account){
            $this->account = session('BisAccount', '', 'bis');
        }
        return $this->account;
    }

    public function status(){
        $data = input('get.');
        $validate = Validate('Base');
        if(!$validate->scene('status')->check($data)){
            $this->error($validate->getError());
        }
        $model = request()->controller();
        $res = model($model)->save($data, ['id'=>intval($data['id'])]);
        if($res){
            $this->success('数据更新成功');
        }else{
            $this->error('数据更新失败');
        }
    }



}