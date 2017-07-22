<?php
namespace app\admin\Controller;
use think\Controller;
use think\Validate;

class Category extends Controller
{

    private $obj;
    public function _initialize()
    {
        $this->obj = model("Category");
    }

    public function index() {

        $parentId = input('get.parent_id', 0, 'intval');
        $category = $this->obj->getFirstCategorys($parentId);
        return $this->fetch('', [
            'category' => $category,
        ]);
    }

    public function add() {

        $categorys = $this->obj->getNormalFirstCategory();

        return $this->fetch('', [
            'categorys'=> $categorys,
        ]);
    }

    public function save() {

        // print_r(input('post.'));
        //print_r(request()->post());
        if(!request()->isPost()){
            $this->error('提交方式不对');
        }
        $data = input('post.');
        $validate = validate('Category');
        if(!$validate->scene('add')->check($data)) {
            $this->error($validate->getError());
        }
        if(!empty($data['id'])){
           return $this->update($data);
        }

        $res = $this->obj->add($data);
        if($res){
            $this->success('数据插入成功');
        }else{
            $this->error('数据插入失败');
        }
    }

    public function edit($id=0){

        if(intval($id) < 1){
            $this->error('参数错误');
        }
        //$id = input('get.id');
        $categorys = $this->obj->getNormalFirstCategory();
        $category = $this->obj->get($id);
        return $this->fetch('', [
            'categorys'=> $categorys,
            'category'=> $category,
        ]);

    }

    public function listorder(){
        $data = input('post.');
        $res = $this->obj->save($data, ['id'=>intval($data['id'])]);
        if($res){
            $this->result($_SERVER['HTTP_REFERER'], 1, 'success');
        }else{
            $this->result($_SERVER['HTTP_REFERER'], 2, 'error');
        }
    }

    public function status(){
        $data = input('get.');
        $validate = Validate('Category');
        if(!$validate->scene('status')->check($data)){
            $this->error($validate->getError());
        }
        $res = $this->obj->save($data, ['id'=>intval($data['id'])]);
        if($res){
            $this->success('数据更新成功');
        }else{
            $this->error('数据更新失败');
        }
    }

    public function update($data){
        $res = $this->obj->save($data, ['id'=>intval($data['id'])]);
        if($res){
            $this->success('数据更新成功');
        }else{
            $this->error('数据更新失败');
        }
    }






}