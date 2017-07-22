<?php
namespace app\bis\Controller;
use think\Controller;
use think\helper\hash\Md5;
use think\Model;

class Deal extends Base {

    public function index(){

        $bis_id = $this->getLoginUser()->bis_id;
        $deal = Model('Deal')->getDealBisId($bis_id);
        return $this->fetch('',[
            'deal' => $deal,
        ]);
    }

    public function add(){

        $bis_id = $this->getLoginUser()->bis_id;
        if(request()->isPost()){
            $data = input('post.');
            //校验
            $location = Model('BisLocation')->get($data['location_ids'][0]);
            $data_deal = [
                'name' => $data['name'],
                'category_id' => $data['category_id'],
                'se_category_id' => empty($data['se_category_id']) ? '' : implode(',', $data['se_category_id']),
                'bis_id' => $bis_id,
                'location_ids' => empty($data['location_ids']) ? '' : implode(',', $data['location_ids']),  //多级门店
                'image' => $data['image'],
                'description' => $data['description'],
                'start_time' => strtotime($data['start_time']),
                'end_time' => strtotime($data['end_time']),
                'origin_price' => $data['origin_price'],
                'current_price' => $data['current_price'],
                'city_id' => $data['city_id'],
                'total_count' => $data['total_count'],
                'coupons_begin_time' => strtotime($data['coupons_begin_time']),  //转换时间戳
                'coupons_end_time' => strtotime($data['coupons_end_time']),  //转换时间戳
                'xpoint' => $location->xpoint,
                'ypoint' => $location->ypoint,
                'bis_account_id' => $this->getLoginUser()->id,
                'balance_price' => 10,
                'notes' => $data['notes'],
            ];
            $res = Model('Deal')->add($data_deal);
            if($res){
                $this->success('团购商品提交成功，等待审核',url('deal/index'));
            }else{
                $this->error('团购商品提交失败');
            }

        }else{
            $Citys = Model('City')->getNormalCitysByParentId();
            $Category = Model('Category')->getNormalFirstCategory();
            $bis_location = model('BisLocation')->getNormalLocationByBisId($bis_id);
            return $this->fetch('',[
                'citys' => $Citys,
                'category' => $Category,
                'bis_location' => $bis_location,
            ]);
        }
    }

}