<?php
namespace app\index\Controller;
use think\Controller;
use think\Model;

class Base  extends Controller{

    public $city = '';
    public $account = '';
    public function _initialize(){

        //城市数据
        $citys = Model('city')->getNormalCitys();
        $this->getCity($citys);

        //获取首页数据
        $cats = $this->getRecommendCats();
        $this->assign('citys',$citys);
        $this->assign('city',$this->city);
        $this->assign('cats',$cats);
        $this->assign('user',$this->getLoginUser());
        $this->assign('controller',strtolower(request()->controller()));
        $this->assign('title','o2o团购网');
    }

    public function getCity($citys){
        $defaultuname = [];
        foreach ($citys as $city) {
               $city = $city->toArray();
               if($city['is_default'] == 1){
                   $defaultuname = $city['uname'];
                   break;
               }
               $defaultuname = $defaultuname ? $defaultuname : 'nanchang';
                if(session('cityname','', 'o2o') && !input('get.city')){
                    $cityname = session('cityname','', 'o2o');
                }else{
                    $cityname = input('get.city', $defaultuname, 'trim');
                    session('cityname',$cityname, 'o2o');
                }
                $this->city = model('city')->where(['uname'=>$cityname])->find();
        }
    }

    public function getLoginUser(){
        if(!$this->account){
            $this->account = session('o2o_user', '', 'o2o');
        }
        return $this->account;
    }

    /**
     * 获取首页推荐的中商品分类
     */
    public function getRecommendCats(){
        $parentIds = $sedcatArr = $recomCats = [];
        $cats = Model('category')->getNormalRecommendCategoryByParentId(0, 5);
        foreach($cats as $cat){
            $parentIds[] = $cat->id;
        }
         //print_r(implode(',', $parentIds));exit;
        $sedCats = Model('category')->getNormalCategoryIdByParentId($parentIds);
        foreach($sedCats as $sedCat){
            $sedcatArr[$sedCat->parent_id][] = [
                'id' => $sedCat->id,
                'name' => $sedCat->name,
            ];
        }
        foreach($cats as $cat){
            // $recomCats 代表是一级和二级的数据 其中[]第一个参数是一级分类的name，第二个参数是此一级的下面所有二级分类的数据
            $recomCats[$cat->id] = [$cat->name, empty($sedcatArr[$cat->id]) ? [] : $sedcatArr[$cat->id] ];
        }

        return $recomCats;

    }


}