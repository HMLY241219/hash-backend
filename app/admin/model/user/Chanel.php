<?php

namespace app\admin\model\user;

use crmeb\basic\BaseModel;
use think\facade\Db;

class Chanel extends BaseModel
{
    protected $name = 'chanel';

    // 递归查询指定用户ID的所有无限级下级数据
    function getAllSubordinates($userId, &$ids, &$names)
    {
        $subordinates = Db::name($this->name)
            ->field('channel, name')
            ->where('parent_id', $userId)
            ->select();

        foreach ($subordinates as $subordinate) {
            $ids[] = $subordinate['id'];
            $names[] = $subordinate['name'];
            getAllSubordinates($subordinate['id'], $ids, $names);
        }
    }

    // 递归查询指定用户ID的所有无限级下级数据
    public function getAllSubordinates2($userId, &$subordinates)
    {
        $data = Db::name($this->name)
            ->field('channel, cname')
            ->where('pchannel', $userId)
            ->select();

        foreach ($data as $item) {
            $subordinate = [
                'channel' => $item['channel'],
                'cname' => $item['cname'],
                'children' => [],
            ];

            $this->getAllSubordinates2($item['channel'], $subordinate['children']);

            $subordinates[] = $subordinate;
        }
    }

    // 递归查询指定用户ID的所有无限级下级数据
    public function getAllSubordinates3($pcid, &$subordinates)
    {
        $data = Db::name($this->name)
            ->field('channel, cname')
            ->where('pchannel', $pcid)
            ->select();

        foreach ($data as $item) {
            $subordinates[] = [
                'channel' => $item['channel'],
                'cname' => $item['cname'],
            ];

            $this->getAllSubordinates3($item['channel'], $subordinates);
        }
    }


}