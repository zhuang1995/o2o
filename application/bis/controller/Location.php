<?php
namespace app\bis\Controller;
use think\Controller;

class Location extends Base{

    public function index(){

        $bis_id = $this->getLoginUser()->bis_id;
        $location = model('BisLocation')->getBisLocationPage($bis_id);
        return $this->fetch('',[
            'location' => $location,
        ]);
    }

    public function status(){
        $data = input('get.');
        $validate = Validate('Location');
        if(!$validate->scene('status')->check($data)){
            $this->error($validate->getError());
        }
        $res = model('BisLocation')->save($data, ['id'=>intval($data['id'])]);
        if($res){
            $this->success('数据更新成功');
        }else{
            $this->error('数据更新失败');
        }
    }

    public function add(){
        if(request()->isPost()){

            $data = input('post.');
            $bis_id = $this->getLoginUser()->bis_id;
            $validate = Validate('Location');
            if(!$validate->scene('add')->check($data)){
                $this->error($validate->getError());
            }
            //获取经纬度
            $lnglat = \Map::getLngLat($data['address']);
            if(empty($lnglat) || $lnglat['status'] !=0 || $lnglat['result']['precise'] !=1){
                $this->error('无法获取数据，或者地址不正确！');
            }
            //商户门店表
            $data['cat'] = '';
            if(!empty($data['se_category_id'])){
                $data['cat'] = implode('|',$data['se_category_id']);
            }
            $data_bis_location = [
                'name' => $data['name'],
                'logo' => $data['logo'],
                'address' => $data['address'],
                'tel' => $data['tel'],
                'contact' => $data['contact'],
                'xpoint' => empty($lnglat['result']['location']['lng']) ? '' : $lnglat['result']['location']['lng'],
                'ypoint' => empty($lnglat['result']['location']['lat']) ? '' : $lnglat['result']['location']['lat'],
                'bis_id' => $bis_id,
                'open_time' => $data['open_time'],
                'content' => $data['content'],
                'is_main' => 1,   //
                'city_id' => $data['city_id'],
                'city_path' => empty($data['se_city_id']) ? $data['city_id'] : $data['city_id'].','.$data['se_city_id'],  //
                'category_id' => $data['category_id'],
                'category_path' => $data['category_id'].','.$data['cat'],
            ];
            $locationId = model('BisLocation')->add($data_bis_location);
            if($locationId){
                $this->success('门店申请成功');
            }else{
                $this->error('门店申请失败');
            }


        }else{
            $Citys = Model('City')->getNormalCitysByParentId();
            $Category = Model('Category')->getNormalFirstCategory();
            return $this->fetch('',[
                'citys' => $Citys,
                'category' => $Category,
            ]);
        }
    }
}