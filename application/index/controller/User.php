<?php
namespace app\index\controller;
use think\Controller;
use think\Model;
use think\Validate;

class User extends	Controller
{

    public function login()
    {
        $user = session('o2o_user', '', 'o2o');
        if($user && $user->id){
            $this->redirect('index/index');
        }
        return $this->fetch();

    }

    public function loginCheck(){
        if(!request()->isPost()){
            $this->error('非法提交');
        }
        $data = input('post.');

        try{
            $user = Model('User')->getUserByUsername($data['username']);
        }catch (\Exception $e){
            $this->error($e->getMessage());
        }
        if(!$user || $user->status != 1){
            $this->error('该用户不合法');
        }
        if($user->password != md5($data['password'].$user->code)){
            $this->error('密码不正确');
        }
        //登陆成功
        Model('user')->updateById(['last_login_time'=> time()], $user->id);
        session('o2o_user',$user,'o2o');
        $this->success('登陆成功', url('index/index'));

    }
	
	public function register()
    {
        if(request()->isPost()){
            $data = input('post.');

            $validate = Validate('User');
            if(!$validate->scene('register')->check($data)){
                $this->error($validate->getError());
            }
            if(!captcha_check($data['verifycode'])){
                $this->error('验证码不正确');
            }
            if($data['password'] != $data['password_en']){
                $this->error('密码有误');
            }
            $data['code'] = mt_rand(100,10000);
            $data['password'] = md5($data['password'].$data['code']);
            $user = Model('user')->add($data);
            if($user){
                $this->success('注册成功',url('user/login'));
            }else{
                $this->error('注册失败，稍后再注册');
            }

        }else{
            return $this->fetch();
        }

    }

    public function logout(){
        session('null','o2o');
        $this->redirect('index/index');

    }
}
