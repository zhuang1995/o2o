<?php
namespace app\api\Controller;
use think\Controller;

class Category extends Controller {

    private $obj;
    public function _initialize()
    {
        $this->obj = model('Category');
    }

    public function getCategoryByParentId() {

        $id = input('post.id', 0, 'intval');
        if(!$id){
            $this->error('id不合法');
        }
        $category = $this->obj->getNormalCategoryByParentId($id);
        if(!$category){
            return show(0, 'error');
        }
        return show(1, 'success', $category);
    }



}