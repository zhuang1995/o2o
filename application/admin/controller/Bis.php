<?php
namespace app\admin\Controller;
use think\Controller;
use think\Model;

class Bis extends Controller{

    private $obj;
    public function _initialize()
    {
        $this->obj = model("Bis");
    }


    public function index(){
        $bis = model('Bis')->getBisStatus(1);
        return  $this->fetch('',[
            'bis' => $bis,
        ]);
    }

    public function apply(){

        $bis = model('Bis')->getBisStatus();
        return  $this->fetch('',[
            'bis' => $bis,
        ]);
    }
    public function detail(){
        $id = input('get.id', 0, 'intval');
        if($id < 0){
            $this->error('数据错误');
        }
        $Citys = Model('City')->getNormalCitysByParentId();
        $Category = Model('Category')->getNormalFirstCategory();
        $bisData = Model('Bis')->get($id);
        $location = Model('BisLocation')->get(['id'=>$id,'is_main'=>1]);
        $account = Model('BisAccount')->get(['id'=>$id,'is_main'=>1]);
        return $this->fetch('',[
            'citys' => $Citys,
            'category' => $Category,
            'bisData' => $bisData,
            'location' => $location,
            'account' => $account,
        ]);
    }

    public function status(){
        $data = input('get.');
        $validate = Validate('Bis');
        if(!$validate->scene('status')->check($data)){
            $this->error($validate->getError());
        }
        $bis_data = $this->obj->save(['status' => $data['status']], ['id'=>$data['id']]);
        $location = Model('BisLocation')->save(['status' => $data['status']], ['bis_id'=>$data['id'],'is_main'=>1]);
        $account = Model('BisAccount')->save(['status' => $data['status']], ['bis_id'=>$data['id'],'is_main'=>1]);
        if($bis_data && $location && $account){
            $this->success('数据更新成功');
        }else{
            $this->error('数据更新失败');
        }
    }


    public function dellist(){
        $bis = model('Bis')->getBisStatus(-1);
        return  $this->fetch('',[
            'bis' => $bis,
        ]);
    }



}