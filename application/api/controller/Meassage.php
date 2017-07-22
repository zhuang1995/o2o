<?php
namespace app\api\Controller;
use think\Controller;

class Meassage extends Controller{


    public function index()
    {
        $input = input('get.');
        if(empty($input['uid']) || empty($input['phone']) || $input['uid'] != 101 ){
            return json(['code'=>400,'message'=>'法非操作']);
        }

        $phone = $input['phone'];
        $code = $this->random(6);	/* 手机验证码 */
        $tpl_id = 26290;		/* 短信模板ID */
        $valid = $this->sendValid($phone,urlencode("#code#=".$code),$tpl_id);
        if($valid){
            /* 成功发送验证码 */
            return json(['code'=>200,'message'=>'短信发送成功']);
        } else {
            /* 验证码发送失败 */
            return json(['code'=>400,'message'=>'短信发送失败']);
        }
    }

    /* 短信接口2号 */
    private function sendValid($mobile,$tpl_value,$tpl_id){
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
    private function random($length, $chars = '0123456789') {
        $hash = '';
        $max = strlen($chars) - 1;
        for($i = 0; $i < $length; $i++) {
            $hash .= $chars[mt_rand(0, $max)];
        }
        return $hash;
    }



}