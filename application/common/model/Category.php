<?php
namespace app\common\Model;
use think\Model;

class Category extends Model {

    protected $autoWriteTimestamp = true;

    public function add($data) {
        $data['status'] = 1;
        return $this->save($data);
    }

    public function getNormalFirstCategory(){
        $data = [
            'status' => 1,
            'parent_id' => 0,
        ];
        $order = [
            'id' => 'desc',
        ];
        return $this->where($data)->order($order)->select();

    }

    public function getFirstCategorys($parentId = 0){
        $data = [
            'parent_id' => $parentId,
            'status' => ['neq', -1],
        ];
        $order = [
            'listorder' => 'desc',
            'id' => 'desc',
        ];
        return $this->where($data)->order($order)->paginate();
    }

    public function getNormalCategoryByParentId($id=0) {

        $data = [
            'status' => 1,
            'parent_id' => $id,
        ];
        $order = [
            'id' => 'desc',
        ];
        return $this->where($data)->order($order)->select();
    }

    /**获取前五个一级分类
     * @param int $id
     * @param int $list
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getNormalRecommendCategoryByParentId($id=0, $list=5){
        $data = [
            'parent_id' => $id,
            'status' => 1,
        ];
        $order = [
            'listorder' => 'desc',
            'id' => 'desc',
        ];
        $result = $this->where($data)->order($order);
        if($list){
            $result = $result->Limit($list);
        }
        return $result->select();
    }

    /*
     * 通过一级id获取二级分类
     */
    public function getNormalCategoryIdByParentId($ids){
        $data = [
            'parent_id' => ['in', implode(',', $ids)],
            'status' => 1,
        ];
        $order = [
            'listorder' => 'desc',
            'id' => 'desc',
        ];
         return $this->where($data)->order($order)->select();

    }



}