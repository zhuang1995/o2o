<?php
namespace app\index\Validate;
use think\Validate;

class User extends Validate
{
    protected $rule = [
        ['username', 'require'],
        ['email', 'require|email'],
        ['password', 'require'],
        ['verifycode', 'require'],
    ];

    /* 场景设置*/
    protected $scene = [
        'register' => ['username', 'email', 'password', 'verifycode'],   //注册
    ];
}