<?php
namespace app\admin\Controller;
use think\Controller;
use think\Model;

class Deal extends Base{

    public function index(){

        $data = input('get.');
        $sdata = [];
        if(!empty($data['start_time']) && !empty($data['end_time']) && strtotime($data['start_time'] < $data['end_time'])){
            $sdata['create_time'] = [
                ['gt', strtotime($data['start_time'])],
                ['lt', strtotime($data['end_time'])],
            ];
        }
        if(!empty($data['category_id'])){
            $sdata['category_id'] = $data['category_id'];
        }
        if(!empty($data['city_id'])){
            $sdata['city_id'] = $data['city_id'];
        }
        if(!empty($data['name'])){
            $sdata['name'] = ['like','%'.$data['name'].'%'];
        }
        $deal = Model('Deal')->getNormalDealData($sdata);
        $cityArray = $categoryArray = [];
        $category = Model('Category')->getNormalCategoryByParentId();
        foreach ($category as $categorys){
            $categoryArray[$categorys->id] = $categorys->name;
        }

        $city = Model('City')->getNormalCitys();
        foreach ($city as $citys){
            $cityArray[$citys->id] = $citys->name;
        }
        return $this->fetch('',[
            'category' => $category,
            'city' => $city,
            'deal' => $deal,
            'category_id' => empty($data['category_id']) ? '' : $data['category_id'],
            'city_id' => empty($data['city_id']) ? '' : $data['city_id'],
            'name' => empty($data['name']) ? '' : $data['name'],
            'start_time' => empty($data['start_time']) ? '' : $data['start_time'],
            'end_time' => empty($data['end_time']) ? '' : $data['end_time'],
            'categoryArray' => $categoryArray,
            'cityArray' => $cityArray,
        ]);
    }
}