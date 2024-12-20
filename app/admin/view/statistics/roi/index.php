{extend name="public/layui"}
{block name="content"}
<div class="layui-fluid" id="app">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="table-reload">
                <div class="layui-card layui-form" lay-filter="form">
                    <div class="layui-card-body layui-row layui-col-space10">


                        <div class="layui-inline">
                            <input type="text" name="date" id="date" value="{:date('Y-m-d',strtotime('-30 day')) .' - '. date('Y-m-d',strtotime('00:00:00'))}" placeholder="时间" autocomplete="off" class="layui-input">
                        </div>

                        <div class="layui-inline">
                            <select id="departmentFirstLevel" name="app" lay-filter="departmentFirstLevel">
                                <option value="">请选择包</option>
                            </select>
                        </div>
                        <div class="layui-inline">
                            <select id="departmentSecondaryLevel" name="network" lay-filter="departmentSecondaryLevel">
                                <option value="">请选择渠道</option>
                            </select>
                        </div>

                        <div class="layui-inline">
                            <button class="layui-btn layui-btn-normal" data-type="reload">搜索</button>
                        </div>


                    </div>
                </div>
            </div>
            <div class="layui-card-body">
                <table class="layui-hide" id="table" lay-filter="table"></table>
            </div>

        </div>
    </div>
</div>
{/block}
{block name="script"}
<script type="text/html" id="act">
    <span class="layui-btn layui-btn-xs layui-btn-warm" onclick="$eb.createModalFrame(this.innerText,`{:url('edit')}?time={{d.time}}`)">编辑消耗</span>
</script>

<script>
    function skip(time,type) {
        if (time == '平均'){
            return;
        }
        var form = document.createElement("form");
        form.style.display = "none";
        form.method = "POST";
        form.action = "{:url('userList')}";
        form.target = "_blank";

        var inputCode = document.createElement("input");
        inputCode.type = "hidden";
        inputCode.name = "time";
        inputCode.value = time;
        var inputType = document.createElement("input");
        inputType.type = "hidden";
        inputType.name = "type";
        inputType.value = type;

        form.appendChild(inputCode);
        form.appendChild(inputType);
        document.body.appendChild(form);

        form.submit();
    }

    function skip2(date, day, type=1, app='', network=''){
        var url = "{:url('statistics.Roichannel/index?date=')}"+date+"&day="+day+"&type="+type+"&app="+app+"&network="+network;
        //console.log(code);
        //window.location.href = url;
        window.open(url);
    }

    layui.use(['table','form','layer','laydate'], function () {
        var form = layui.form,table = layui.table,layer = layui.layer,laydate = layui.laydate;
        laydate.render({
            elem: '#date',
            range : true
        });

        var ChannelData = "{$ChannelData}";
        var decodedString = ChannelData.replace(/&quot;/g, '"');
        var ChannelDataArray = JSON.parse(decodedString);
        console.log(ChannelDataArray, 3333);

        // 初始化第一个选择框
        var firstSelect = document.getElementById('departmentFirstLevel');
        ChannelDataArray.forEach(function (item) {
            var option = document.createElement('option');
            option.value = item.value;
            option.text = item.name;
            firstSelect.appendChild(option);
        });
        form.render('select'); // 重新渲染选择框

        // 监听第一个选择框的变化
        form.on('select(departmentFirstLevel)', function (data) {
            var selectedValue = data.value;
            var secondSelect = document.getElementById('departmentSecondaryLevel');

            // 清空第二个选择框
            secondSelect.innerHTML = '<option value="">请选择渠道</option>';

            // 填充第二个选择框
            ChannelDataArray.forEach(function (item) {
                if (item.value == selectedValue && item.list !== undefined) {
                    item.list.forEach(function (subItem) {
                        var option = document.createElement('option');
                        option.value = subItem.value;
                        option.text = subItem.name;

                        secondSelect.appendChild(option);
                    });
                }
            });

            form.render('select'); // 重新渲染选择框
        });

        var limit = 500;


        var defaultToolbar = "{$defaultToolbar}"
        var decodedString = defaultToolbar.replace(/&quot;/g, '"');
        var toolbarArray = JSON.parse(decodedString);
        console.log(toolbarArray,222);

        table.render({
            elem: '#table'
            ,defaultToolbar: toolbarArray
            ,url: "{:url('getlist')}",

            /*parseData: function(res) { //res 即为原始返回的数据
                // 在这里你可以对原始数据进行修改，比如添加平均数行
                var avgRow = calculateAverage(res.data); // 假设你有一个函数来计算平均数
                res.data.unshift(avgRow); // 将平均数行添加到数据的开头
                return res;
            },*/

            cellMinWidth: 100 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
            ,method:'post'
            ,toolbar: '#toolbar'
            ,totalRow: true // 开启合计行
            ,height: 'full-30'
            ,limit: limit //每页默认显示的数量
            ,limits: [500,1000,2000,5000] //每页默认显示的数量
            ,page : true
            ,cols: [[
                {field: 'time', title: '注册日期', minWidth: 110,fixed: 'left'},
                {field: 'num', title: '新增注册', minWidth: 80,fixed: 'left'},
                /*{field: 'num', title: '新增注册', minWidth: 130,fixed: 'left',templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.time}}`, 0)">{{ d.num }}</a></div>'
                },
                {field: 'day2', title: '次日留存', minWidth: 100,templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.time}}`, 1)">{{ d.day2 }}</a></div>'
                },
                {field: 'day3', title: '3日留存', minWidth: 100,templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.time}}`, 2)">{{ d.day3 }}</a></div>'
                },
                {field: 'day4', title: '4日留存', minWidth: 100,templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.time}}`, 3)">{{ d.day4 }}</a></div>'
                },
                {field: 'day5', title: '5日留存', minWidth: 100,templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.time}}`, 4)">{{ d.day5 }}</a></div>'
                },
                {field: 'day6', title: '6日留存', minWidth: 100,templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.time}}`, 5)">{{ d.day6 }}</a></div>'
                },
                {field: 'day7', title: '7日留存', minWidth: 100,templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.time}}`, 6)">{{ d.day7 }}</a></div>'
                },
                {field: 'day8', title: '8日留存', minWidth: 100,templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.time}}`, 7)">{{ d.day8 }}</a></div>'
                },
                {field: 'day9', title: '9日留存', minWidth: 100,templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.time}}`, 8)">{{ d.day9 }}</a></div>'
                },
                {field: 'day10', title: '10日留存', minWidth: 120,templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.time}}`, 9)">{{ d.day10 }}</a></div>'
                },*/
                {field: 'consume', title: '消耗总额', minWidth: 80},
                //{field: 'recharge', title: '付费总额', minWidth: 80},
                {field: 'recharge', title: '付费总额', minWidth: 120, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip2(`{{d.time}}`, 1, 2, `{{d.app}}`, `{{d.network}}`)">{{ d.recharge }}</a></div>'
                },
                {field: 'all_roi', title: '累计ROI', minWidth: 90},
                {field: 'ltv', title: '终身LTV', minWidth: 90},
                //{field: 'day1', title: '1日ROI', minWidth: 120},
                {field: 'day1', title: '1日ROI', minWidth: 120, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip2(`{{d.time}}`, 1)">{{ d.day1 }}</a></div>'
                },
                {field: 'day2', title: '2日ROI', minWidth: 120, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip2(`{{d.time}}`, 2)">{{ d.day2 }}</a></div>'
                },
                {field: 'day3', title: '3日ROI', minWidth: 120, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip2(`{{d.time}}`, 3)">{{ d.day3 }}</a></div>'
                },
                {field: 'day4', title: '4日ROI', minWidth: 120, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip2(`{{d.time}}`, 4)">{{ d.day4 }}</a></div>'
                },
                {field: 'day5', title: '5日ROI', minWidth: 120, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip2(`{{d.time}}`, 5)">{{ d.day5 }}</a></div>'
                },
                {field: 'day6', title: '6日ROI', minWidth: 120, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip2(`{{d.time}}`, 6)">{{ d.day6 }}</a></div>'
                },
                {field: 'day7', title: '7日ROI', minWidth: 120, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip2(`{{d.time}}`, 7)">{{ d.day7 }}</a></div>'
                },
                {field: 'day8', title: '8日ROI', minWidth: 120, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip2(`{{d.time}}`, 8)">{{ d.day8 }}</a></div>'
                },
                {field: 'day9', title: '9日ROI', minWidth: 120, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip2(`{{d.time}}`, 9)">{{ d.day9 }}</a></div>'
                },
                {field: 'day10', title: '10日ROI', minWidth: 120, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip2(`{{d.time}}`, 10)">{{ d.day10 }}</a></div>'
                },
                {field: 'day11', title: '11日ROI', minWidth: 120, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip2(`{{d.time}}`, 11)">{{ d.day11 }}</a></div>'
                },
                {field: 'day12', title: '12日ROI', minWidth: 120, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip2(`{{d.time}}`, 12)">{{ d.day12 }}</a></div>'
                },
                {field: 'day13', title: '13日ROI', minWidth: 120, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip2(`{{d.time}}`, 13)">{{ d.day13 }}</a></div>'
                },
                {field: 'day14', title: '14日ROI', minWidth: 120, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip2(`{{d.time}}`, 14)">{{ d.day14 }}</a></div>'
                },
                {field: 'day15', title: '15日ROI', minWidth: 120, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip2(`{{d.time}}`, 15)">{{ d.day15 }}</a></div>'
                },
                {field: 'day16', title: '16日ROI', minWidth: 120, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip2(`{{d.time}}`, 16)">{{ d.day16 }}</a></div>'
                },
                {field: 'day17', title: '17日ROI', minWidth: 120, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip2(`{{d.time}}`, 17)">{{ d.day17 }}</a></div>'
                },
                {field: 'day18', title: '18日ROI', minWidth: 120, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip2(`{{d.time}}`, 18)">{{ d.day18 }}</a></div>'
                },
                {field: 'day19', title: '19日ROI', minWidth: 120, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip2(`{{d.time}}`, 19)">{{ d.day19 }}</a></div>'
                },
                {field: 'day20', title: '20日ROI', minWidth: 120, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip2(`{{d.time}}`, 20)">{{ d.day20 }}</a></div>'
                },
                {field: 'day21', title: '21日ROI', minWidth: 120, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip2(`{{d.time}}`, 21)">{{ d.day21 }}</a></div>'
                },
                {field: 'day22', title: '22日ROI', minWidth: 120, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip2(`{{d.time}}`, 22)">{{ d.day22 }}</a></div>'
                },
                {field: 'day23', title: '23日ROI', minWidth: 120, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip2(`{{d.time}}`, 23)">{{ d.day23 }}</a></div>'
                },
                {field: 'day24', title: '24日ROI', minWidth: 120, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip2(`{{d.time}}`, 24)">{{ d.day24 }}</a></div>'
                },
                {field: 'day25', title: '25日ROI', minWidth: 120, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip2(`{{d.time}}`, 25)">{{ d.day25 }}</a></div>'
                },
                {field: 'day26', title: '26日ROI', minWidth: 120, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip2(`{{d.time}}`, 26)">{{ d.day26 }}</a></div>'
                },
                {field: 'day27', title: '27日ROI', minWidth: 120, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip2(`{{d.time}}`, 27)">{{ d.day27 }}</a></div>'
                },
                {field: 'day28', title: '28日ROI', minWidth: 120, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip2(`{{d.time}}`, 28)">{{ d.day28 }}</a></div>'
                },
                {field: 'day29', title: '29日ROI', minWidth: 120, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip2(`{{d.time}}`, 29)">{{ d.day29 }}</a></div>'
                },
                {field: 'day30', title: '30日ROI', minWidth: 120, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip2(`{{d.time}}`, 30)">{{ d.day30 }}</a></div>'
                },

                /*{field: 'day30', title: '30日留存', minWidth: 120,templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.time}}`, 29)">{{ d.day30 }}</a></div>'
                },
                {field: 'day45', title: '45日留存', minWidth: 120,templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.time}}`, 34)">{{ d.day35 }}</a></div>'
                },*/
                {fixed: 'right', title: '操作', align: 'center', width: 130, toolbar: '#act'}
            ]]
        });

        // 一个假设的函数，用于计算每列的平均数
        function calculateAverage(data) {
            var avgRow = {};
            var columns = Object.keys(data[0]);

            columns.forEach(function(column) {
                var sum = 0;
                var count = 0;

                data.forEach(function(row) {
                    var value = row[column];
                    var matches = value.match(/\((\d+)\)/); // 使用正则表达式匹配括号中的值

                    if (matches && matches.length > 1) {
                        var number = parseInt(matches[1]); // 将匹配到的值转换为整数
                        sum += number;
                        count++;
                    } else {
                        count++;
                        if (column == 'num'){
                            var number = parseFloat(value); // 将无括号的值转换为浮点数
                            if (!isNaN(number)) {
                                sum += number;
                            }
                        }
                    }
                });

                var average = sum / count;
                if (column == 'time'){
                    avgRow[column] = '平均';
                }else {
                    avgRow[column] = average.toFixed(2);
                }
            });

            return avgRow;
        }


        active = {
            reload: function () {
                console.log( form.val('form'),111111);
                table.reload("table", {
                    page: {
                        curr: 1
                    },
                    where: form.val('form'),
                    scrollPos: 'fixed',
                });
            },

        };

        $(".table-reload .layui-btn").on("click", function () {
            const type = $(this).data("type");
            active[type] && active[type]();
        });


    });


    new Vue({
        el: '#app',
        data: {
            aaa: 0,
        },
        created(){

        },
        methods: {

        },

    })
</script>
{/block}


