<?php
namespace app\index\controller;
use think\Controller;
use think\Model;

class Index extends	Base
{
    public function index()
    {
        //广告图

        //首页产品
        $deal = Model('Deal')->getNormalDealByCategoryCityId(1,$this->city->id);
        //print_r($this->city->id);exit;
        $category = model('category')->getNormalRecommendCategoryByParentId(1,5);
		return $this->fetch('',[
		    'deal' => $deal,
            'category' => $category,
        ]);
    }
}
