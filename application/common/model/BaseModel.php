<?php
namespace app\common\Model;
use think\Model;

class BaseModel extends Model{

   public function _initialize(){

   }
    protected $autoWriteTimestamp = true;
    public function add($data) {
        $data['status'] = 0;
        $this->allowField(true)->save($data);
        return $this->id;
    }

    /**用户登录更新操作
     * @param $data
     * @param $id
     */
    public function updateById($data,$id){
            return $this->allowField(true)->save($data, ['id'=>$id]);
    }
}