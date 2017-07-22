<?php
namespace app\admin\Validate;
use think\Validate;

class Base extends Validate
{
    protected $rule = [
        ['status', 'require'],
        ['id', 'require'],
        ['parent_id', 'require'],
        ['name', 'require'],
        ['uname', 'require'],
        ['title', 'require'],
        ['image', 'require'],
        ['type', 'require'],
        ['url', 'require'],
        ['description', 'require'],
        ['title', 'require'],
    ];

    /* 场景设置*/
    protected $scene = [
        'status' => ['name', 'id'],   //添加
        'featured' => ['title', 'image', 'type', 'url', 'description', 'title'],  //推荐位
        'city' => ['parent_id', 'name', 'uname'], //城市添加
    ];
}