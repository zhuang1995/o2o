<?php
namespace app\bis\Validate;
use think\Validate;

class Base extends Validate
{
    protected $rule = [
        ['id', 'require'],
        ['status', 'require'],

    ];

    /* 场景设置*/
    protected $scene = [
        'status' => ['name', 'status'],   //状态
    ];
}