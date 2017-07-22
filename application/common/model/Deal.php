<?php
namespace app\common\Model;
use think\Model;

class Deal extends BaseModel {

    public function getDealBisId($bis_id){
        $data = [
            'bis_id' => $bis_id,
            'status' => ['neq', -1],
        ];
        $order = [
            'id' => 'desc',
        ];
        return $this->where($data)->order($order)->paginate();

    }

    public function getNormalDealData($data=[]){
        $order = [
            'id' => 'desc',
        ];
        return $this->where($data)->order($order)->paginate();
    }

    /**通过
     * @param $id   分类id
     * @param $city 城市
     * @param int $limit    条数
     */
    public function getNormalDealByCategoryCityId($id, $city, $limit=10){
            $data = [
              'end_time' => ['gt', time()],
              'category_id' => $id,
              'city_id' => $city,
              'status' => 1,
            ];
            $order = [
                'id' => 'desc',
            ];
            $result = $this->where($data)->order($order)->limit($limit)->select();
            return $result;
    }

    /**通过data数据和排序查找相应的列表页数据
     * @param array $data
     * @param array $oreder
     */
    public function getDealByConditions($data=[], $oreders){
        if(!empty($oreders['order_sales'])){
            $oreder['buy_count'] = 'desc';
        }
        if(!empty($oreders['order_price'])){
            $oreder['current_price'] = 'desc';
        }
        if(!empty($oreders['order_time'])){
            $oreder['create_time'] = 'desc';
        }
        $oreder['id'] = 'desc';
        $datas[] = "end_time > ".time();
        if(!empty($data['se_category_id'])){
            $datas[] = " find_in_set(".$data['se_category_id'].",se_category_id)";
        }
        if(!empty($data['category_id'])){
            $datas[] = 'category_id = '.$data['category_id'];
        }
        if(!empty($data['city_id'])){
            $datas[] = 'city_id = '.$data['city_id'];
        }
        $datas[] = 'status=1';

       return $this->where(implode(' AND ', $datas))->order($oreder)->paginate();
       //echo $this->getLastSql();exit;

    }


}