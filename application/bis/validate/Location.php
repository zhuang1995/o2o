<?php
namespace app\bis\Validate;
use think\Validate;

class Location extends Validate
{
    protected $rule = [
        ['name', 'require|max:30'],
        ['logo', 'require'],
        ['address', 'require'],
        ['tel', 'require'],
        ['contact', 'require'],
        ['bis_id', 'require'],
        ['open_time', 'require'],
        ['content', 'require'],
        ['city_id', 'require'],
        ['category_id', 'require'],
        ['category_path', 'require'],
        ['status', 'require'],
        ['id', 'require'],
    ];

    /* 场景设置*/
    protected $scene = [
        'add' => ['name', 'logo', 'address', 'tel', 'contact', 'open_time', 'content', 'category_id'],   //添加
        'status' => ['status', 'id'],
    ];
}