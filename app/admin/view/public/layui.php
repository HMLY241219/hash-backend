<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="{__FRAME_PATH}js/jquery.min.js"></script>
    <link href="{__PLUG_PATH}layui/css/layui.css" rel="stylesheet">
    <script src="{__PLUG_PATH}layui/layui.js"></script>
    <script>
        $eb = parent._mpApi;
        // if(!$eb) top.location.reload();
    </script>
    {block name="head"}{/block}
</head>
{block name="style"}{/block}
<body class="gray-bg">
<div class="wrapper wrapper-content">
{block name="content"}{/block}
{block name="script"}{/block}
</div>

<script>
    //点击图片放大
    $(document).on('click', '.image',function(){
        layer.photos({
            photos: {
                // "title": "", //相册标题
                // "id": 123, //相册id
                // "start": 0, //初始显示的图片序号，默认0
                "data": [   //相册包含的图片，数组格式
                    {
                        // "alt": "图片名",
                        // "pid": 666, //图片id
                        "src": $(this).attr ("src"), //原图地址
                        // "thumb": "" //缩略图地址
                    }
                ]
            }
            ,anim: 0 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
        })

    });
    function getUserType(num) {
        let list = [
            '零充用户',
            '<span class="layui-font-green">首充用户</span>',
            '<span class="layui-font-blue">初级用户</span>',
            '<span class="layui-font-purple">中级用户</span>',
            '<span class="layui-font-orange">高级用户</span>',
            '<span class="layui-font-gold">特殊用户</span>'
        ];

        list['-1'] = '<span class="layui-font-cyan">AI</span>';

        return list[num];
    }

    function getGameType(num, lv,control_win_or_loser = 0) {
        if(control_win_or_loser !== 0){
            var list = {
                1001: `<span><i class="layui-icon layui-icon-face-smile layui-bg-red"></i><span style="color:#ff7500"> Rummy</span> [${lv}]`,
                1002: `<span><i class="layui-icon layui-icon-face-smile layui-bg-red"></i><span style="color:#9370db">TP</span> [${lv}]`,
                1003: `<span><i class="layui-icon layui-icon-face-smile layui-bg-red"></i><span style="color: orangered;">TeenPatti</span>[${lv}]`,
                1501: `<span><i class="layui-icon layui-icon-face-smile layui-bg-red"></i><span class="layui-font-yellow">新AB</span>`,
                1502: `<span><i class="layui-icon layui-icon-face-smile layui-bg-red"></i><span class="layui-font-green">Wheel Of Fortune</span>`,
                1503: `<span><i class="layui-icon layui-icon-face-smile layui-bg-red"></i><span><span class="layui-font-cyan"> 龙虎</span>`,
                1504: `<span><i class="layui-icon layui-icon-face-smile layui-bg-red"></i><span class="layui-font-blue">7up骰子</span>`,
                1505: `<span><i class="layui-icon layui-icon-face-smile layui-bg-red"></i><span class="layui-font-purple">印度骰子</span>`,
                //1025: `<span style="color: mediumpurple">Joker</span>`,
                //1024: `<span style="color: skyblue">AK47</span>`,
                1506: `<span><i class="layui-icon layui-icon-face-smile layui-bg-red"></i><span style="color:#029402">wingo</span>`,
                1507: `<span><i class="layui-icon layui-icon-face-smile layui-bg-red"></i><span style="color:#cd5c5c">国王与皇后</span>`,
                1508: `<span><i class="layui-icon layui-icon-face-smile layui-bg-red"></i><span style="color:#1e90ff">百人金花</span>`,
                2001: `<span><i class="layui-icon layui-icon-face-smile layui-bg-red"></i><span style="color:#00bfff">水果机</span>`,
            };
        }else {
            var list = {
                1001: `<span style="color:#ff7500">Rummy</span> [${lv}]`,
                1002: `<span style="color:#9370db">TP</span> [${lv}]`,
                1003: `<span style="color: orangered;">TeenPatti</span>[${lv}]`,
                1501: `<span class="layui-font-yellow">新AB</span>`,
                1502: `<span class="layui-font-green">Wheel Of Fortune</span>`,
                1503: `<span class="layui-font-cyan"> Dranon Tiger</span>`,
                1504: `<span class="layui-font-blue">Lucky Dice</span>`,
                1505: `<span class="layui-font-purple">Jhandi Munda</span>`,
                //1025: `<span style="color: mediumpurple">Joker</span>`,
                //1024: `<span style="color: skyblue">AK47</span>`,
                1506: `<span style="color:#029402">Lucky Ball</span>`,
                1507: `<span style="color:#cd5c5c">国王与皇后</span>`,
                1508: `<span style="color:#1e90ff">3 Patti Bet</span>`,
                1509: `<span style="color:#1e90ff">Andar Bahar</span>`,
                1510: `<span style="color:#1e90ff">Mine</span>`,
                1511: `<span style="color:#1e90ff">Blastx</span>`,
                1512: `<span style="color:#1e90ff">Mines</span>`,
                1513: `<span style="color:#1e90ff">Mines2</span>`,
                1514: `<span style="color:#1e90ff">Aviator</span>`,

                2001: `<span style="color:#00bfff">水果机</span>`,
            };
        }


        return list[num] || '<span class="layui-btn layui-btn-primary layui-btn-xs">后台功能暂未开发</span>';
    }

    function listGameType(num) {
        let list = {
            1001: `<span style="color:#ff7500">Rummy</span>`,
            1002: `<span style="color:#9370db">TP</span>`,
            1501: `<span class="layui-font-yellow">新AB</span>`,
            1502: `<span class="layui-font-green">转盘游戏</span>`,
            1503: `<span class="layui-font-cyan">龙虎</span>`,
            1504: `<span class="layui-font-blue">7up骰子</span>`,
            1505: `<span class="layui-font-purple">印度骰子</span>`,
            //1025: `<span style="color: mediumpurple">Joker</span>`,
            //1024: `<span style="color: skyblue">AK47</span>`,
            1506: `<span style="color:#029402">wingo</span>`,
            1507: `<span style="color:#cd5c5c">国王与皇后</span>`,
            1508: `<span style="color:#1e90ff">百人金花</span>`,
            //1019: `<span style="color: orangered;">新TP</span>`,
            2001: `<span style="color:#00bfff">水果机</span>`,
            1509: `<span style="color:orangered">老AB</span>`
        };

        return list[num] || '';
    }

    function listGameTypeNew(num) {
        let list = {
            111111: `<span style="color:#ff7500">全部</span>`,
            1001999: `<span style="color:#ff7500">RM</span>`,
            10010: `<span style="color:#ff7500">RM练习场(10卢比)</span>`,
            10011: `<span style="color:#ff7500">RM五人0.1块场</span>`,
            10012: `<span style="color:#ff7500">RM五人1块场</span>`,
            10013: `<span style="color:#ff7500">RM五人2块场</span>`,
            10014: `<span style="color:#ff7500">RM五人5块场</span>`,
            10015: `<span style="color:#ff7500">RM五人10块场</span>`,
            100151: `<span style="color:#ff7500">RM双人0.1块场</span>`,
            100152: `<span style="color:#ff7500">RM双人0.3块场</span>`,
            100153: `<span style="color:#ff7500">RM双人1块场</span>`,
            100154: `<span style="color:#ff7500">RM双人2.5块场</span>`,
            100155: `<span style="color:#ff7500">RM双人5块场</span>`,
            100156: `<span style="color:#ff7500">RM双人10块场</span>`,
            100157: `<span style="color:#ff7500">RM双人20块场</span>`,
            100158: `<span style="color:#ff7500">RM双人50块场</span>`,
            1001100: `<span style="color:#ff7500">金币场</span>`,
            1002999: `<span style="color:#9370db">TP</span>`,
            10021: `<span style="color:#9370db">TP(0.1块场)</span>`,
            10022: `<span style="color:#9370db">TP(0.3块场)</span>`,
            10023: `<span style="color:#9370db">TP(1块场)</span>`,
            10024: `<span style="color:#9370db">TP(5块场)</span>`,
            10025: `<span style="color:#9370db">TP(10块场)</span>`,
            10026: `<span style="color:#9370db">TP(20块场)</span>`,
            10027: `<span style="color:#9370db">TP(50块场)</span>`,
            1003999: `<span style="color:#9370db">新TP</span>`,
            10031: `<span style="color:#9370db">新TP(0.1块场)</span>`,
            10032: `<span style="color:#9370db">新TP(0.3块场)</span>`,
            10033: `<span style="color:#9370db">新TP(1块场)</span>`,
            10034: `<span style="color:#9370db">新TP(5块场)</span>`,
            10035: `<span style="color:#9370db">新TP(10块场)</span>`,
            10036: `<span style="color:#9370db">新TP(50块场)</span>`,
            //10037: `<span style="color:#9370db">新TP(50块场)</span>`,
            15011: `<span class="layui-font-yellow">新AB</span>`,
            15021: `<span class="layui-font-green">转盘游戏</span>`,
            15031: `<span class="layui-font-cyan">龙虎</span>`,
            15041: `<span class="layui-font-blue">7up骰子</span>`,
            15051: `<span class="layui-font-purple">印度骰子</span>`,
            //1025: `<span style="color: mediumpurple">Joker</span>`,
            //1024: `<span style="color: skyblue">AK47</span>`,
            15061: `<span style="color:#029402">wingo</span>`,
            15071: `<span style="color:#cd5c5c">国王与皇后</span>`,
            15081: `<span style="color:#1e90ff">百人金花</span>`,
            //1019: `<span style="color: orangered;">新TP</span>`,
            20011: `<span style="color:#00bfff">水果机</span>`,
            15091: `<span style="color:#9a4c2f">老AB</span>`,
            15101: `<span style="color:#d2d587">Mine</span>`,
            15111: `<span style="color:#a8441f">Blastx</span>`,
            15121: `<span style="color:#1d3a1c">Mines</span>`,
            15131: `<span style="color:#2b8146">Mines2</span>`,
            15141: `<span style="color:#272878">Aviator</span>`,
            15151: `<span style="color:#272878">Lucky Jet</span>`,
            15161: `<span style="color:#272878">Rocket Queen</span>`,

            11: `<span style="color:#1d6e58">Pgsoft</span>`,
            21: `<span style="color:#1059a1">Pragmatic Play</span>`,
            31: `<span style="color:#721995">TaDa</span>`,
            41: `<span style="color:orangered">Egslot</span>`,
            51: `<span style="color:#a35233">CQ9</span>`,
            61: `<span style="color:#e4d9d4">Saba Sports</span>`,
            71: `<span style="color:#91951f">Sbo Bet</span>`,
            81: `<span style="color:#790d81">3377WIN</span>`,
            91: `<span style="color:orangered">JiLi</span>`,
            101: `<span style="color:#5de7ec">WE</span>`,
            111: `<span style="color:orangered">Ezugi</span>`,
            121: `<span style="color:orangered">JDB</span>`,
            131: `<span style="color:orangered">Evolution</span>`,
            141: `<span style="color:orangered">Spribe</span>`,
            151: `<span style="color:orangered">BG</span>`,
            161: `<span style="color:orangered">Joker</span>`,
            171: `<span style="color:orangered">Turbo</span>`,
        };

        return list[num] || '';
    }

    function getRedNumber(num, div = false) {
        if (num === undefined) return '';

        num = (div === true) ? num / 100 : num;

        return num < 0 ? `<span style="color:#ff0005">${num}</span>` : num;
    }

    // function getDateString(time, date = false) {
    //     let string = new Date((time - 2.5 * 3600) * 1000);
    //
    //     return date ? string.toLocaleDateString() : string.toLocaleString();
    // }
    // 中国时区
    function getDateString(timestamp, date = false) {
        var options = {
            timeZone: 'Asia/Kolkata',
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };
        var formatter = new Intl.DateTimeFormat([], options);
        var indiaDateTimeString = formatter.format(new Date(timestamp * 1000));
        return indiaDateTimeString;
    }

    // 中国时区
    function getDateString2(time, date = false) {
        let string = new Date(time * 1000);

        return date ? string.toLocaleDateString() : string.toLocaleString();
    }

    function getDivisor(num1, num2, minus = false, plus = false) {
        if (!num1 || !num2) return 0;

        let divisor = num1 / num2;

        let number;
        if (minus === true && plus === false) {
            number = (1 - divisor) * 100;
        } else if (minus === false && plus === true) {
            number = (1 + divisor) * 100;
        } else {
            number = divisor * 100;
        }

        if (number == 0) return 0;

        return Math.floor(number * 1000) / 1000 + '%';
    }


    // 印度时区
    function formatIndiaDateTime(timestamp) {
        var options = {
            timeZone: 'Asia/Kolkata',
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };
        var formatter = new Intl.DateTimeFormat([], options);
        var indiaDateTimeString = formatter.format(new Date(timestamp * 1000));
        return indiaDateTimeString;
    }

    function getDivNum(num1, num2, percent = true, div = false, precision = 100) {
        if (num1==0 || num2==0) return 0;
        if (div) return Math.floor((num1 / num2) * 100) / 100;
        return Math.floor(((num1 / num2) * 100) * precision) / precision + (percent ? '%' : '');
    }

</script>

<!--全局layout模版-->
</body>
</html>
