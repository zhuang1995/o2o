<?php
namespace app\admin\controller;
use think\Controller;

class Index extends	Controller
{
    public function index()
    {
		return $this->fetch();
    }
	
	public function welcome()
    {

		return "欢迎来到o2o商城";
    }
    public function email(){
        \phpmailer\Email::send('402527966@qq.com','o2o','网站测试');
        return "发生成功";
    }



}
