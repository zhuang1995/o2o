<?php
namespace app\admin\Validate;
use think\Validate;

class Bis extends Validate
{
    protected $rule = [
        ['status', 'require'],
        ['id', 'require'],
    ];

    /* 场景设置*/
    protected $scene = [
        'status' => ['name', 'id'],   //添加

    ];
}