<?php
namespace app\index\Controller;
use think\Controller;
use think\Model;

class Detail extends Base {

    public function index($id){

        if(!intval($id)){
            $this->error('ID不合法');
        }
        $deal = model('Deal')->get($id);
        if(!$deal || $deal->status != 1){
            $this->error('商品不存在或者其他原因');
        }
        //分类信息
        $category = Model('category')->get($deal->category_id);
        //分店信息
        if(preg_match('/,/', $deal->location_ids)){
            $location = Model('BisLocation')->getNormalLoationId($deal->location_ids);
            $location_name = $location[0]->name;
        }else{
            $location = Model('BisLocation')->getNormalLocationPoint($deal->location_ids);
            $location_name = $location[0]->name;
            //print_r($location);exit;
        }
        //开团时间
        $star = 0;
        if($deal->start_time > time()){
            $star = 1;
            $start_time = $deal->start_time - time();
            $time_dey = '';
            $d = floor($start_time/(3600*24));
            if($d){
                $time_dey .= $d . "天";
            }
            $h = floor($start_time%(3600*24)/3600);
            if($h){
                $time_dey .= $h . "小时";
            }
            $m = floor($start_time%(3600*24)%3600/60);
            if($m){
                $time_dey .= $m . "分";
            }

            $this->assign('time_dey',$time_dey);
        }


        return $this->fetch('',[
            'deal' => $deal,
            'title' => $deal->name,
            'category' => $category,
            'location_name' => $location_name,
            'star' => $star,
            'imgsrc' => $location[0]->xpoint .',' . $location[0]->ypoint,
            'count' => $deal->total_count - $deal->buy_count,
        ]);
    }

}