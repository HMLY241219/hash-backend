<?php

namespace app\admin\controller\widget;

use app\admin\controller\AuthController;
use think\facade\Route as Url;
use app\admin\model\system\{
    SystemAttachment as SystemAttachmentModel, SystemAttachmentCategory as Category
};
use crmeb\services\{JsonService as Json, JsonService, UtilService as Util, FormBuilder as Form};
use crmeb\services\upload\Upload;

/**
 * TODO 附件控制器
 * Class Images
 * @package app\admin\controller\widget
 */
class Image extends AuthController
{
    /**后台上传图片
     * $file 接收文件名字的参数
     * @param $suffixname
     */
    public function file($file,$suffixname = '.png'){

        $FILES = $_FILES;

        $dirname = date('Ymd');
        $path= root_path().'public/uploads/images/'.$dirname;

        if(!file_exists($path)){
            //检查是否有该文件夹，如果没有就创建，并给予最高权限
            mkdir($path,0777,true);
        }
        $name = \customlibrary\Common::doOrderSn(789);

        $tmp = isset($FILES[$file]['tmp_name']) ? $FILES[$file]['tmp_name'] : '';
        if(!$tmp){
            return json(['code' => 201 , 'code' => 'error','data' => []]);
        }
        $file_path = '/uploads/images/'.$dirname.'/'.$name.$suffixname;
        if(move_uploaded_file($tmp,$path.'/'.$name.$suffixname)){
            Json::success('上传成功',['filePath' => $file_path]);
        }else{
            Json::fail('上传失败');
        }
    }
}

