<?php
namespace app\api\Controller;
use think\Controller;

class City extends Controller {

    private $obj;
    public function _initialize()
    {
        $this->obj = model('City');
    }

    public function getCitysByParentId($id) {

        $id = input('post.id');
        if(!$id){
            $this->error('id不合法');
        }
        $city = $this->obj->getNormalCitysByParentId($id);
        if(!$city){
            return show(0, 'error');
        }
        return show(1, 'success', $city);
    }

    public function index()
    {
        $duanx_phone = 13144124152;
        $code = $this->random(6);	/* 手机验证码 */
        $tpl_id = 26290;		/* 短信模板ID */
        $valid = $this->sendValid($duanx_phone,urlencode("#code#=".$code),$tpl_id);
        if( $valid ){
            /* cookie设置一个临时验证码 (60秒) */
            if(!$_COOKIE["temp_valid"]){
                setcookie("temp_valid", md5($code), time()+60);
            }
            /* 成功发送验证码 */
            echo 6;
            return;
        } else {
            /* 验证码发送失败 */
            echo 7;
            return;
        }
    }

    /* 短信接口2号 */
    public function sendValid($mobile,$tpl_value,$tpl_id){
        $tpl_id = $tpl_id ? $tpl_id : '26290';   /* 模板ID */
        /* 6位验证码 */
        $tpl_value = is_numeric($tpl_value) ? urlencode("#code#=".$tpl_value) : $tpl_value;

        $key = '2e6bb09e21a2ccec10a201a603228414';
        /* 发送验证码 */
        $url = 'http://v.juhe.cn/sms/send?mobile='.$mobile.'&tpl_id='.$tpl_id.'&tpl_value='.$tpl_value.'&key='.$key;
        $res = doCurl($url);

        /* 错误码为0 表示获取成功 */
        if($res){
            $res = json_decode($res,true);
            if($res['error_code'] == 0){
                return true;
            }else{
                return false;
            }

        }else{
            return false;
        }
    }

    //随机数
    public function random($length, $chars = '0123456789') {
        $hash = '';
        $max = strlen($chars) - 1;
        for($i = 0; $i < $length; $i++) {
            $hash .= $chars[mt_rand(0, $max)];
        }
        return $hash;
    }





}