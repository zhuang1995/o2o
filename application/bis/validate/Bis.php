<?php
namespace app\bis\Validate;
use think\Validate;

class Bis extends Validate
{
    protected $rule = [
        ['name', 'require|max:30'],
        ['email', 'email'],
        ['description', 'require'],
        ['city_id', 'require'],
        ['bank_info', 'require'],
        ['bank_name', 'require'],
        ['bank_user', 'require'],
        ['faren', 'require'],
        ['faren_tel', 'require'],
        ['username', 'require'],
        ['password', 'require'],
    ];

    /* 场景设置*/
    protected $scene = [
        'add' => ['name', 'email', 'description', 'city_id', 'bank_info', 'bank_name', 'bank_user', 'faren', 'faren_tel', 'username', 'password'],   //添加
    ];
}