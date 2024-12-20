<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
use think\facade\Db;

if (!function_exists('attr_format')) {
    /**
     * 格式化属性
     * @param $arr
     * @return array
     */
    function attr_format($arr)
    {
        $data = [];
        $res = [];
        $count = count($arr);
        if ($count > 1) {
            for ($i = 0; $i < $count - 1; $i++) {
                if ($i == 0) $data = $arr[$i]['detail'];
                //替代变量1
                $rep1 = [];
                foreach ($data as $v) {
                    foreach ($arr[$i + 1]['detail'] as $g) {
                        //替代变量2
                        $rep2 = ($i != 0 ? '' : $arr[$i]['value'] . '_$_') . $v . '-$-' . $arr[$i + 1]['value'] . '_$_' . $g;
                        $tmp[] = $rep2;
                        if ($i == $count - 2) {
                            foreach (explode('-$-', $rep2) as $k => $h) {
                                //替代变量3
                                $rep3 = explode('_$_', $h);
                                //替代变量4
                                $rep4['detail'][$rep3[0]] = isset($rep3[1]) ? $rep3[1] : '';
                            }
                            if($count == count($rep4['detail']))
                                $res[] = $rep4;
                        }
                    }
                }
                $data = isset($tmp) ? $tmp : [];
            }
        } else {
            $dataArr = [];
            foreach ($arr as $k => $v) {
                foreach ($v['detail'] as $kk => $vv) {
                    $dataArr[$kk] = $v['value'] . '_' . $vv;
                    $res[$kk]['detail'][$v['value']] = $vv;
                }
            }
            $data[] = implode('-', $dataArr);
        }
        return [$data, $res];
    }
}
if (!function_exists('get_month')) {
    /**
     * 格式化月份
     * @param string $time
     * @param int $ceil
     * @return array
     */
    function get_month($time = '', $ceil = 0)
    {
        if (empty($time)) {
            $firstday = date("Y-m-01", time());
            $lastday = date("Y-m-d", strtotime("$firstday +1 month -1 day"));
        } else if ($time == 'n') {
            if ($ceil != 0)
                $season = ceil(date('n') / 3) - $ceil;
            else
                $season = ceil(date('n') / 3);
            $firstday = date('Y-m-01', mktime(0, 0, 0, ($season - 1) * 3 + 1, 1, date('Y')));
            $lastday = date('Y-m-t', mktime(0, 0, 0, $season * 3, 1, date('Y')));
        } else if ($time == 'y') {
            $firstday = date('Y-01-01');
            $lastday = date('Y-12-31');
        } else if ($time == 'h') {
            $firstday = date('Y-m-d', strtotime('this week +' . $ceil . ' day')) . ' 00:00:00';
            $lastday = date('Y-m-d', strtotime('this week +' . ($ceil + 1) . ' day')) . ' 23:59:59';
        }
        return array($firstday, $lastday);
    }
}
if (!function_exists('clearfile')) {
    /**删除目录下所有文件
     * @param $path 目录或者文件路径
     * @param string $ext
     * @return bool
     */
    function clearfile($path, $ext = '*.log')
    {
        $files = (array)glob($path . DS . '*');
        foreach ($files as $path) {
            if (is_dir($path)) {
                $matches = glob($path . '/' . $ext);
                if (is_array($matches)) {
                    array_map('unlink', $matches);
                }
                rmdir($path);
            } else {
                unlink($path);
            }
        }
        return true;
    }
}
if (!function_exists('get_this_class_methods')) {
    /**获取当前类方法
     * @param $class
     * @return array
     */
    function get_this_class_methods($class, $unarray = [])
    {
        $arrayall = get_class_methods($class);
        if ($parent_class = get_parent_class($class)) {
            $arrayparent = get_class_methods($parent_class);
            $arraynow = array_diff($arrayall, $arrayparent);//去除父级的
        } else {
            $arraynow = $arrayall;
        }
        return array_diff($arraynow, $unarray);//去除无用的
    }
}

if (!function_exists('verify_domain')) {

    /**
     * 验证域名是否合法
     * @param string $domain
     * @return bool
     */
    function verify_domain(string $domain): bool
    {
        $res = "/^(?=^.{3,255}$)(http(s)?:\/\/)(www\.)?[a-zA-Z0-9][-a-zA-Z0-9]{0,62}(\.[a-zA-Z0-9][-a-zA-Z0-9]{0,62})+(:\d+)*(\/\w+\.\w+)*$/";
        if (preg_match($res, $domain))
            return true;
        else
            return false;
    }
}

if (!function_exists('get_range_date'))
{
    function get_range_date($first, $last = '', $format = 'Y-m-d')
    {
        if (strpos($first, ' ~ '))
        {
            [$first, $last] = explode(' ~ ', $first);
        }

        $first = is_numeric($first) ? $first : strtotime($first);
        $last  = is_numeric($last)  ? $last  : strtotime($last);

        $days = ($last - $first) / 86400 + 1;
        $date = [];
        for ($i = 0; $i < $days; $i++)
        {
            $date[] = date($format, $first + (86400 * $i));
        }

        return $date;
    }
}

if (!function_exists('get_year_week'))
{
    function get_year_week($dates)
    {
        $date = get_range_date($dates, null, 'Y_W');

        return array_flip(array_flip($date));
    }
}

if (!function_exists('get_game_name')) {
    function get_game_name($id)
    {
        $list = [
            100002 => 'TeenPatti',
            100001 => 'Rummy',
            100003 => 'AndarBahar',
            100004 => '7Up7Down',
            100005 => 'Dragon&Tiger',
            100006 => '',
            100007 => '3PattiBet',
            100008 => 'WingoLottery',
            100009 => 'SpeedRacing',
            100010 => 'ZooParty',
            100037 => 'StarBurst',
            100040 => 'Strike',

            //100012 => 'VoodooTemple',
            //100013 => 'FruitStackCashMachine',
            //100014 => 'CherrySupreme',
            //100015 => 'FireJoker',
            //100016 => 'FruitSlot',

            //100031 => 'ZooParty',
            //100032 => 'Double',
            //100033 => 'Crash',
            //100034 => 'BingoSoccer',
            //100035 => 'Mines',
            //100037 => 'Starburst',
            //100039 => 'FreeStart',
            //100040 => 'Strike'
        ];

        return $id === true ? $list : $list[$id] ?? 'None';
    }
}

/**
 * layui数据
 * @param $flie 文件
 * @return void
 */
function leadingIn($file)
{

    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));//获取文件扩展名

    if($file_extension != 'xlsx' && $file_extension != 'xls'){
        return false;
    }
    //实例化PHPExcel类
    if ($file_extension == 'xlsx'){
        $objReader =\PHPExcel_IOFactory::createReader('Excel2007');
    } else if ($file_extension == 'xls') {
        $objReader =\PHPExcel_IOFactory::createReader('Excel5');
    }


    $obj_PHPExcel =$objReader->load($file['tmp_name']);
    if($obj_PHPExcel){

        $sheetContent = $obj_PHPExcel->getSheet(0)->toArray();
        //删除第一行标题
        unset($sheetContent[0]);

        return $sheetContent;
    }
    return false;
}

/*function getCardName(){
    $cards = ['0x01','0x02','0x03','0x04','0x05','0x06','0x07','0x08','0x09','0x0A','0x0B','0x0C','0x0D',
        '0x11','0x12','0x13','0x14','0x15','0x16','0x17','0x18','0x19','0x1A','0x1B','0x1C','0x1D',
        '0x21','0x22','0x23','0x24','0x25','0x26','0x27','0x28','0x29','0x2A','0x2B','0x2C','0x2D',
        '0x31','0x32','0x33','0x34','0x35','0x36','0x37','0x38','0x39','0x3A','0x3B','0x3C','0x3D'];
}*/

/*function getCardName($decimal) {
    $dechex = dechex($decimal);
    if ($dechex == '4e') return '小王';
    if ($dechex == '4f') return '大王';
    if (strlen($dechex) == 1){
        $dechex = '0'.$dechex;
    }
    [$n1, $n2] = str_split($dechex);

    switch ($n1) {
        case 0:
            $str1 = '方块';
            break;
        case 1:
            $str1 = '梅花';
            break;
        case 2:
            $str1 = '红桃';
            break;
        case 3:
            $str1 = '黑桃';
            break;
        default:
            $str1 = '未知';
            break;
    }
    switch ($n2) {
        case 'a':
            $str2 = '10';
            break;
        case 'b':
            $str2 = 'J';
            break;
        case 'c':
            $str2 = 'Q';
            break;
        case 'd':
            $str2 = 'K';
            break;
        case '1':
            $str2 = 'A';
            break;
        default:
            $str2 = $n2;
            break;
    }

    return $str1 . ' ' . $str2;
}*/

function getCardName($num)
{
    if (!$num) return $num;

    $dechex = dechex($num);

    if ($dechex == '51') return '小王';
    if ($dechex == '52') return '大王';

    [$n1, $n2] = str_split($dechex);
    switch ($n1) {
        case 1:
            $str1 = '方块';
            break;
        case 2:
            $str1 = '梅花';
            break;
        case 3:
            $str1 = '红桃';
            break;
        case 4:
            $str1 = '黑桃';
            break;
    }
    switch ($n2) {
        case 'a':
            $str2 = '10';
            break;
        case 'b':
            $str2 = 'J';
            break;
        case 'c':
            $str2 = 'Q';
            break;
        case 'd':
            $str2 = 'K';
            break;
        case '1':
            $str2 = 'A';
            break;
        default:
            $str2 = $n2;
            break;
    }

    return $str1 . ' ' . $str2;
}

function getCardType($num = 0)
{
    $list = [
        '', '豹子', '同花顺', '顺子', '同花', '一对', '高牌'
    ];

    return $num === true ? $list : $list[$num];
}

function tpStatus($num = 0)
{
    $list = [
        '0', 'win', 'lost', 'pack', 'wait'
    ];

    return $list[$num] ?? '';
}

/**
 * 获取包名
 * @param $admin_info 管理员信息
 * @return array
 */
function getPkg($admin_info = []){
    if (!empty($admin_info) && $admin_info['level']!=0 && !empty($admin_info['pkg_name'])){
        $pkg = Db::connect('gc_log')->name('day_data')->whereIn('pkg_name',$admin_info['pkg_name'])->group('pkg_name')->column('pkg_name');
    }else{
        $pkg = Db::connect('gc_log')->name('day_data')->group('pkg_name')->column('pkg_name');
    }
    $pkg_arr = array_filter($pkg);
    $data = [];
    if (!empty($pkg_arr)){
        foreach ($pkg_arr as $key=>$value){
            if ($value != 'NONE' && $value != 'com.gaming.tphub.sharf' && $value != 'com.gaming.tphub.sharg') {
                $data[$key]['name'] = $value;
                $data[$key]['value'] = $value;
            }
        }
    }
    sort($data);
    return $data;
}

function getChannel($admin_info = []){
    if (!empty($admin_info) && $admin_info['level']!=0 && !empty($admin_info['channel'])){
        $channel = Db::connect('gc_log')->name('day_data')->whereIn('channel',$admin_info['channel'])->group('channel')->column('channel');
    }else{
        $channel = Db::connect('gc_log')->name('day_data')->group('channel')->column('channel');
    }
    $channel_arr = array_filter($channel);
    $data = [];
    if (!empty($channel_arr)){
        foreach ($channel_arr as $key=>$value){
            if ($value != 'None') {
                $data[$key]['name'] = $value;
                $data[$key]['value'] = $value;
            }
        }
    }
    sort($data);
    return $data;
}

function getGameType($num)
{

    $list = [
        1001 => '<span style="color:#ff7500">Rummy</span> ',
        1002=> '<span style="color:#9370db">TP</span>',
        1003=> '<span style="color:#9370db">新TP</span>',
        1501=> '<span class="layui-font-yellow">新AB</span>',
        1502=> '<span class="layui-font-green">Wheel Of Fortune</span>',
        1503=> '<span class="layui-font-red">Dranon Tiger</span>',
        1504=> '<span class="layui-font-blue">Lucky Dice</span>',
        1505=> '<span class="layui-font-purple">Jhandi Munda</span>',
        //1025: '<span style="color: mediumpurple">Joker</span>',
        //1024: '<span style="color: skyblue">AK47</span>',
        1506=> '<span style="color:#029402">Lucky Ball</span>',
        1507=> '<span style="color:#cd5c5c">国王与皇后</span>',
        1508=> '<span style="color:#1e90ff">3 Patti Bet</span>',
        1509=> '<span style="color:#1e90ff">Andar Bahar</span>',
        1510=> '<span style="color:#1e90ff">Mine</span>',
        1511=> '<span style="color:#1e90ff">Blastx</span>',
        1512=> '<span style="color:#1e90ff">Mines</span>',
        1513=> '<span style="color:#1e90ff">Mines2</span>',
        1514=> '<span style="color:#1e90ff">Aviator</span>',
        //1019: '<span style="color: orangered;">新TP</span>',
        2001=> '<span style="color:#00bfff">水果机</span>',

    ];



    return $list[$num] ?? '<span class="layui-btn layui-btn-primary layui-btn-xs">开发中</span>';
}

function getResultBy1018($num = 0)
{
    $list = ['黄', '蓝', '红'];

    return $list[$num];
}

function getResultBy1026($num = 0)
{
    $list = ['', '', '大对子', '金花', '顺子', '金顺子', '豹子'];

    return $list[$num] ?? '';
}

function getResultBy1028($num)
{
    $list = ['KING', 'QUEEN', 'TIE', 'SUITED TIE'];

    return $list[$num];
}

function getResultBy1021($num)
{
    $list = ['龙', '虎', '象'];

    return $list[$num];
}

//老AB第一轮开奖结果
function getOneOldAb($num)
{
    $list = ['黑桃', '红桃', '梅花','方块'];

    return $list[$num] ?? '';
}

//老AB第二轮开奖结果
function getTwoOldAb($num)
{
    $list = [ 4 => '左',5 => '右'];

    return $list[$num] ?? '';
}

function getOldAbSession($num)
{
    $list = [-1 => '第一轮', 4 => '第二轮',5 => '第二轮'];

    return $list[$num] ?? '';
}
