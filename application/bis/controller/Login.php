<?php
namespace app\bis\Controller;
use think\Controller;

class Login extends Controller {

    public function index() {

        if(request()->isPost()){

            $data = input('post.');
            $ret = model('BisAccount')->get(['username' =>$data['username']]);
            if(!$ret || $ret->status != 1){
                $this->error('用户不存在，或者没有被审核通过');
            }
            if($ret->password != md5($data['password'].$ret->code)){
                $this->error('密码不正确');
            }
            model('BisAccount')->updateById(['last_login_time'=>time()], $ret->id);
            //保存信息
            session('BisAccount', $ret, 'bis');
            return $this->success('登陆成功', url('index/index'));
        }else{
            $account = session('BisAccount', '', 'bis');
            if($account && $account->id){
                return $this->redirect('index/index');
            }
            return $this->fetch();
        }

    }

    public function logout(){
        session(null,'bis');
        return $this->redirect('login/index');

    }

}