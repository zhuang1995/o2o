<?php
namespace app\api\Controller;
use think\Controller;
use think\Request;
use think\File;

class Image extends Controller {

    public function upload() {
        $file = Request::instance()->file('file');
        $info = $file->move('uploadify');
        if($file && $info->getPathname()){
            return show(1, 'success', '/'.$info->getPathname());
        }
        return show(0, 'error');
    }



}