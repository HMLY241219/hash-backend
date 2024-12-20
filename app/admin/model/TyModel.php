<?php

namespace app\admin\model;

use crmeb\basic\BaseModel;
use think\model\concern\SoftDelete;

abstract class TyModel extends BaseModel
{

    use SoftDelete;

    protected $connection = 'ty';

    protected $pk = 'id';

    protected $autoWriteTimestamp = true;

    protected $createTime = 'ctime';

    protected $updateTime = 'utime';

    protected $deleteTime = false;

    protected $defaultSoftDelete = 0;

    final static function setField($id, $name, $value)
    {
        return static::update([$name => $value], ['id' => $id]);
    }

    private static function parseWhere($maps = [])
    {
        $like = $maps['like'] ?? 0;
        unset($maps['page'], $maps['limit'], $maps['like']);

        $model = new static();
        foreach ($maps as $field => $value)
        {
            if ($value === '') continue;

            $model = $model
                ->when($value || $value >= 0, function ($query) use ($field, $value) {
                    $query->where($field, '=', $value);
                })
                ->when($value && $like, function ($query) use ($field, $value) {
                    $query->whereLike($field, '%' . $value . '%', 'OR');
                });
        }

        return $model;
    }

    /**
     * @param mixed $param
     * @param mixed $order
     * @return array
     */
    final static function getDataSet($param, $order = '')
    {
        $orderBy = ['id' => 'desc'];
        if ($order)
        {
            if (is_array($order))
            {
                $orderBy = array_merge($order, $orderBy);
            }
            elseif (is_string($order))
            {
                $orderBy = ['id' => $order];
            }
        }

        $count = self::parseWhere($param)->count();
        $data  = self::parseWhere($param)->order($orderBy)
            ->page($param['page'], $param['limit'])->select()->toArray();

        return compact('count', 'data');
    }

}