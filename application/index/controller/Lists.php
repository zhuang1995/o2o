<?php
namespace app\index\Controller;
use think\Controller;

class Lists extends Base{

    public function index(){
        $firstCatIds = [];
        $categroys = Model('Category')->getNormalCategoryByParentId();
       foreach($categroys as $categroy){
           $firstCatIds[] = $categroy->id;
       }
        $id = input('id', 0, 'intval');
        $data = [];
        if(in_array($id,$firstCatIds)){
            //一级分类
            $categoryParentId = $id;
            //根据id获取数据
            $data['category_id'] = $categoryParentId;
        }else if($id){
            //二级分类
            $categroy = Model('Category')->get($id);
            if(!$categroy || $categroy->status != 1){
                $this->error('数据不合法');
            }
            $categoryParentId = $categroy->parent_id;
            //根据id获取商品数据
            $data['se_category_id'] = $id;
        }else{
            $categoryParentId = 0;
        }
        $sedcategorys = [];
        if($categoryParentId){
            $sedcategorys = Model('Category')->getNormalCategoryByParentId($categoryParentId);
        }
        //排序
        $order_sales = input('order_sales', '');
        $order_price = input('order_price', '');
        $order_time = input('order_time', '');
        $order = [];
        if(!empty($order_sales)){
            $orderflag = 'order_sales';
            $order['order_sales'] = $orderflag;
        }else if(!empty($order_price)){
            $orderflag = 'order_price';
            $order['order_price'] = $orderflag;
        }else if(!empty($order_time)){
            $orderflag = 'order_time';
            $order['order_time'] = $orderflag;
        }else{
            $orderflag = '';
        }
        $data['city_id'] = $this->city->id;
        //获取商品数据
        $deals = model('Deal')->getDealByConditions($data,$order);

        return $this->fetch('',[
            'categorys' => $categroys,
            'categoryParentId' => $categoryParentId,
            'id' => $id,
            'sedcategorys' => $sedcategorys,
            'orderflag' => $orderflag,
            'deals' => $deals,
        ]);
    }

}