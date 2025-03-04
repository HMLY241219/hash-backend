<?php
/**
 * @author: xaboy<365615158@qq.com>
 * @day: 2017/11/13
 */

namespace app\admin\model\system;

use crmeb\services\upload\Upload;
use crmeb\traits\ModelTrait;
use crmeb\basic\BaseModel;

/**
 * 文件检验model
 * Class SystemFile
 * @package app\admin\model\system
 */
class SystemAttachment extends BaseModel
{

    /**
     * 数据表主键
     * @var string
     */
    protected $pk = 'att_id';

    /**
     * 模型名称
     * @var string
     */
    protected $name = 'system_attachment';

    use ModelTrait;

    /**
     * TODO 添加附件记录
     * @param $name
     * @param $att_size
     * @param $att_type
     * @param $att_dir
     * @param string $satt_dir
     * @param int $pid
     * @param int $imageType
     * @param int $time
     * @return SystemAttachment
     */
    public static function attachmentAdd($name, $att_size, $att_type, $att_dir, $satt_dir = '', $pid = 0, $imageType = 1, $time = 0, $module_type = 1)
    {
        $data['name'] = $name;
        $data['att_dir'] = $att_dir;
        $data['satt_dir'] = $satt_dir;
        $data['att_size'] = $att_size;
        $data['att_type'] = $att_type;
        $data['image_type'] = $imageType;
        $data['module_type'] = $module_type;
        $data['time'] = $time ? $time : time();
        $data['pid'] = $pid;
        return self::create($data);
    }

    /**
     * TODO 获取分类图
     * @param $id
     * @return array
     */
    public static function getAll($id)
    {
        $model = new self;
        $where['pid'] = $id;
        $where['module_type'] = 1;
        $model->where($where)->order('att_id desc');
        return $model->page($model, $where, '', 24);
    }

    /** 获取图片列表
     * @param $where
     * @return array
     */
    public static function getImageList($where)
    {
        $model = new self;
        $model = $model->where('module_type', 1);
        if (isset($where['pid']) && $where['pid']) {
            $model = $model->where('pid', $where['pid']);
        }else{
            $model = $model->where('pid', '<>', 20);
        }
        $model = $model->page((int)$where['page'], (int)$where['limit']);
        $model = $model->order('att_id desc,time desc');
        $list = $model->select();
        $list = count($list) ? $list->toArray() : [];
        $site_url = sys_config('site_url');
        foreach ($list as &$item) {
            if ($site_url) {
                $item['satt_dir'] = (strpos($item['satt_dir'], $site_url) !== false || strstr($item['satt_dir'], 'http') !== false) ? $item['satt_dir'] : $site_url . $item['satt_dir'];
                $item['att_dir'] = (strpos($item['att_dir'], $site_url) !== false || strstr($item['att_dir'], 'http') !== false) ? $item['satt_dir'] : $site_url . $item['att_dir'];
            }
        }
        $count = $where['pid'] ? self::where(['pid' => $where['pid'], 'module_type' => 1])->count() : self::where('module_type', 1)->count();
        return compact('list', 'count');
    }

    /**
     * TODO 获取单条信息
     * @param $value
     * @param string $field
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getInfo($value, $field = 'att_id')
    {
        $where[$field] = $value;
        $count = self::where($where)->count();
        if (!$count) return false;
        return self::where($where)->find()->toArray();
    }

    /**
     * 清除昨日海报
     * @return bool
     * @throws \Exception
     */
    public static function emptyYesterdayAttachment()
    {
        $list = self::whereTime('time', 'yesterday')->where('module_type',2)->field('name,att_dir,att_id,image_type')->select();
        try {
            $uploadType = (int)sys_config('upload_type', 1);
            $upload = new Upload($uploadType, [
                'accessKey' => sys_config('accessKey'),
                'secretKey' => sys_config('secretKey'),
                'uploadUrl' => sys_config('uploadUrl'),
                'storageName' => sys_config('storage_name'),
                'storageRegion' => sys_config('storage_region'),
            ]);
            foreach ($list as $key => $item) {
                if ($item['image_type'] == 1) {
                    $att_dir = $item['att_dir'];
                    if ($att_dir && strstr($att_dir, 'uploads') !== false) {
                        if (strstr($att_dir, 'http') === false)
                            $upload->delete($att_dir);
                        else {
                            $filedir = substr($att_dir, strpos($att_dir, 'uploads'));
                            if ($filedir) $upload->delete($filedir);
                        }
                    }
                } else {
                    if ($item['name']) $upload->delete($item['name']);
                }
            }
            self::whereTime('time', 'yesterday')->where('module_type', 2)->delete();
            return true;
        } catch (\Exception $e) {
            self::whereTime('time', 'yesterday')->where('module_type', 2)->delete();
            return true;
        }
    }
}