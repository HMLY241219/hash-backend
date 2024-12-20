<?php

namespace app\admin\controller;


use think\facade\Db;




class Common
{


    /**
     * layui数据
     * @param $flie 文件
     * @return void
     */
    public static function leadingIn($file)
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

    /**
     * @return array|false
     * @param  $list 数组
     * @param  $filed 字段也就是Excel的第一列注释与上面数组格式相同
     * @param $filename
     */
    public static function daoChuExcel($list = [],$filed = [],$filename = 'test'){
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()
            ->setCreator("Your Name")
            ->setLastModifiedBy("Your Name")
            ->setTitle("Array to Excel")
            ->setSubject("Array to Excel")
            ->setDescription("Demo on how to convert an array to Excel using PHPExcel")
            ->setKeywords("array, excel, phpexcel");
        $data = [];
        $data[] = $filed;
        foreach ($list as $v){
            $data[] = $v;
        }
        // 将数组写入 Excel 文件
        $objPHPExcel->getActiveSheet()->fromArray($data);
        // 设置当前活动表格索引为第一个表格，以便在打开文件时让它成为默认表格
        $objPHPExcel->setActiveSheetIndex(0);
        // 保存 Excel 文件
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save($filename.'.xlsx');

        return 111;

    }


    /**
     * @param $msg_id  msg_id
     * @param $uid uid
     * @param $update_int  修改的参数
     * @param $reason reason
     * @param $remark 备注
     * @param $divisor 除数
     * @param $game_num 游戏次数
     * @param $score 总输赢
     * @return void
     */
    public static function exec_php_data($msg_id,$uid,$update_int,$reason,$game_num = '',$score = '',$remark,$divisor = 100){
        if($game_num != '' && $score == ''){

            $jsonstr = json_encode(['msg_id' => $msg_id,'uid'=>(int)$uid,'update_int64' => (int)$update_int ,'game_num' =>(int)$game_num,'reason' => (int)$reason]);

        }elseif ($game_num == '' && $score != ''){

            $jsonstr = json_encode(['msg_id' => $msg_id,'uid'=>(int)$uid,'update_int64' => (int)$update_int ,'score' =>(int)$score,'reason' => (int)$reason]);

        }elseif($game_num == '' && $score == ''){

            $jsonstr = json_encode(['msg_id' => $msg_id,'uid'=>(int)$uid,'update_int64' => (int)$update_int ,'reason' => (int)$reason]);


        }else{
            $jsonstr = json_encode(['msg_id' => $msg_id,'uid'=>(int)$uid,'update_int64' => (int)$update_int ,'game_num' =>(int)$game_num,'score' =>(int)$score,'reason' => (int)$reason]);

        }
        $userphpexec = [
            'type' => 100,
            'uid' => $uid,
            'jsonstr' => $jsonstr,
            'description' => $divisor ? $remark.bcdiv($update_int,$divisor,2) : $remark.$update_int,
        ];

        return $userphpexec;
    }


    /**
     * PG历史记录发送gm命令
     * @param $msg_id  msg_id
     * @param $uid uid
     * @param $update_int  修改的参数
     * @param $reason reason
     * @param $remark 备注
     * @param $divisor 除数
     * @param $game_num 游戏次数
     * @param $score 总输赢
     * @return void
     */
    public static function pgexec_php_data($msg_id,$uid,$update_int,$reason,$game_num = 0,$score = 0,$remark,$divisor = 100){
        $jsonstr = json_encode(['msg_id' => $msg_id,'uid'=>(int)$uid,'update_int64' => (int)$update_int ,'game_num' =>(int)$game_num,'score' =>(int)$score,'reason' => (int)$reason]);
        $userphpexec = [
            'type' => 100,
            'uid' => $uid,
            'jsonstr' => $jsonstr,
            'description' => $divisor ? $remark.bcdiv($update_int,$divisor,2) : $remark.$update_int,
        ];
        return $userphpexec;
    }

    public static function setTeamLevel($uid,$puid = 0,$type = 0,$level = 0, $share_strlog){

        //第一次进来，如果有团队详细数据就直接返回。
        if(!$level){
            self::installTeamLevel($uid,$uid,0);
            //存储团队信息
            if($puid > 0){
                Db::name('user_agent_team')->insert([
                    'uid' => $uid,
                    'puid' => $puid,
                    'type' => $type,
                    'level' => $level,
                    'createtime' => time(),
                    'avatar' => $share_strlog['avatar'],
                    'nickname' => $uid,
                ]);
            }else{
                return 1;
            }
        }

        //防止层级过多出问题，这里最多设置10级
        if($level >= 5)return 1;

        //获取代理的上级用户,如果不存在直接返回
        $user_agent = Db::name('agent')->field('puid,bili')->where('uid',$puid)->find();
        if(!$user_agent)return 1;
        self::installTeamLevel($uid,$puid,$user_agent['bili'],$level + 1);
        //如果推荐代理有上级用户，同时上级用户不是代理自己
        if($user_agent['puid'] > 0 && $user_agent['puid'] != $puid) self::setTeamLevel($uid,$user_agent['puid'],$type,$level + 1, $share_strlog);
        return 1;
    }

    /**
     * 储存用户团队层级数据
     * @return void 存储
     */
    public static function installTeamLevel($uid,$puid,$bili,$level = 0){
        Db::name('agent_teamlevel')->insert([
            'uid' => $uid,
            'puid' => $puid,
            'level' => $level,
            'bili' => $bili,
            'createtime' => time(),
        ]);
    }

}
