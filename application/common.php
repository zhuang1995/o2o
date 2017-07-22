<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function status($status){
    if($status == 1){
        $str = "<span class='label label-success radius'>正常</span>";
    }else if($status ==0){
        $str = "<span class='label label-success radius' style='background-color: red;'>待审</span>";
    }else{
        $str = "<span class='label label-success radius'>删除</span>";
    }
    return $str;
}

/*
 * curl操作
 * */
function doCurl($url, $type=0, $data=[]){

    $ch = curl_init(); //初始化
    //设置选项
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);

    if($type == 1){
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }

    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}
/*
 * 分页
 * */
function Navigation($obj){
    if(!$obj){
        return '';
    }
    $params = request()->param();
    return "<div class='cl pd-5 bg-1 bk-gray mt-20 tp5-o2o'>".$obj->appends($params)->render()."</div>";

}
/*
 * 二级城市获取
 * */
function getSeCityName($city_path){
    if(empty($city_path)){
        return '';
    }
    if(preg_match('/,/', $city_path)){
        $cityPath = explode(',', $city_id);
        $city_id = $city_path[1];
    }else{
        $city_id = $city_path;
    }
    $city = model('City')->get($city_id);
    return $city->name;
}

/*
 * 二级分类获取
 * */
function getCategoryName($category_path){
    if(empty($category_path)){
        return '';
    }
    if(preg_match('/,/', $category_path)){
        $categoryPath = explode(',', $category_path);
        if(empty($categoryPath[1])){
            return '';
        }
        $catrgory_id = $categoryPath[1];
    }else{
        $catrgory_id = $category_path;
    }
    $category = model('Category')->get($catrgory_id);

    return '<input name="se_category_id[]" type="checkbox" id="checkbox-moban" value="'.$category->id.'"/>' .$category->name.'<label for="checkbox-moban">&nbsp;</label>';
}

/*
 * 查看是否为总店信息
 * */
function getLocation($is_main){
    $main_name = '';
    if($is_main == 0){
        $main_name = '不是';
    }else if($is_main == 1){
        $main_name = '是';
    }
    return $main_name;
}

function countLocation($ids){
    if(!$ids){
        return 1;
    }
    if(preg_match('/,/', $ids)){
        $arr = explode(',',$ids);
        return count($arr);
    }else{
        return 1;
    }




}