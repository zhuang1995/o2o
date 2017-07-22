<?php
namespace app\bis\Controller;
use think\Controller;
use think\Model;
use think\Validate;

class Register extends Controller {

    public function index() {
        $Citys = Model('City')->getNormalCitysByParentId();
        $Category = Model('Category')->getNormalFirstCategory();
        return $this->fetch('',[
            'citys' => $Citys,
            'category' => $Category,
        ]);
    }

    public function add() {
        if(!request()->isPost()){
            $this->error('提交错误');
        }else{
            $data = input('post.');
            $validate = Validate('Bis');
            if(!$validate->scene('add')->check($data)){
                $this->error($validate->getError());
            }
            //获取经纬度
            $lnglat = \Map::getLngLat($data['address']);
            if(empty($lnglat) || $lnglat['status'] !=0 || $lnglat['result']['precise'] !=1){
                $this->error('无法获取数据，或者地址不正确！');
            }
            //商户表
            $data_bis = [
                'name' => $data['name'],
                'email' => $data['email'],
                'logo' => $data['logo'],
                'licence_logo' => $data['licence_logo'],
                'description' => $data['description'],
                'city_id' => $data['city_id'],
                'city_path' => empty($data['city_path']) ? $data['city_id'] : $data['city_id'] .','.$data['city_path'],
                'bank_info' => $data['bank_info'],
                'bank_name' => $data['bank_name'],
                'bank_user' => $data['bank_user'],
                'faren' => $data['faren'],
                'faren_tel' => $data['faren_tel'],
            ];

            $bis_id = model('Bis')->add($data_bis);

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

            //商户账号表
            $bis_account_code = rand(100,10000);
            $data_bis_account = [
                'username' => $data['username'],
                'password' => md5($data['password'].$bis_account_code),
                'code' => $bis_account_code,
                'bis_id' => $bis_id,
                'is_main' => 1,
            ];
            $bis_location = model('BisLocation')->add($data_bis_location);
            $bis_account = model('BisAccount')->add($data_bis_account);
            if($bis_location || $bis_account){
                $this->success('提交成功',url('login/index'));
            }else{
                $this->error('数据提交失败');
            }
        }
    }
}