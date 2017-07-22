<?php
namespace app\admin\Controller;
use think\Controller;
use think\Validate;

class Featured extends Base{

    private $obj;
    public function _initialize()
    {
        $this->obj = model("Featured");
    }

    public function index(){
        $types = config('featured.featured_type');
        $type = input('get.type', 0, 'intval');
        $featured = $this->obj->getFeaturedsByType($type);
        //print_r($featured);exit;
        return $this->fetch('',[
            'featured' => $featured,
            'types' => $types,
            'type' => $type,
        ]);
    }

    public function add(){

        if(request()->isPost()){
            $data = input('post.');
            $validate = Validate('Base');
            if(!$validate->scene('featured')->check($data)){
                $this->error($validate->getError());
            }
            //print_r($data);exit;
            $featured = model('Featured')->add($data);
            if($featured){
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
        }

        $types = config('featured.featured_type');
        return $this->fetch('',[
            'types' => $types,
        ]);
    }

}