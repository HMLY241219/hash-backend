<?php

namespace app\admin\model\operate;

use app\admin\model\Model;

class Notices extends Model
{
    protected $name = 'notice';

    public function setStartAttr($value) { return $value ? strtotime($value) : ''; }

    public function getStartAttr($value) { return $value ? date('Y-m-d H:i:s', $value) : ''; }

    public function setEndAttr($value) { return $value ? strtotime($value) : ''; }

    public function getEndAttr($value) { return $value ? date('Y-m-d H:i:s', $value) : ''; }


}