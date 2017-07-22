<?php
namespace app\common\Model;
use think\Model;

class City extends Model {

    protected $autoWriteTimestamp = true;

    public function add($data) {
        $data['status'] = 1;
        return $this->allowField(true)->save($data);
    }

    /**获取一级城市
     * @param int $id
     * @return array
     */
    public function getNormalCitysByParentId($id=0) {

        $data = [
            'status' => 1,
            'parent_id' => $id,
        ];
        $order = [
            'id' => 'desc',
        ];
        return $this->where($data)->order($order)->select();
    }

    /**获取二级城市
     * @return array
     */
    public function getNormalCitys() {

        $data = [
            'status' => 1,
            'parent_id' => ['gt',0],
        ];
        $order = [
            'id' => 'desc',
        ];
        return $this->where($data)->order($order)->select();
    }

    /**
     * 获取一级分类，分页查询
     */
    public function getFirstCitys($id=0){
        $data = [
            'status' => 1,
            'parent_id' => $id,
        ];
        $order = [
            'id' => 'desc',
        ];
        return $this->where($data)->order($order)->paginate();

    }



}