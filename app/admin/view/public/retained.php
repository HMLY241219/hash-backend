{extend name="public/layui"}
{block name="content"}
<div class="layui-fluid" id="app">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="table-reload">
                <div class="layui-card layui-form" lay-filter="form">
                    <div class="layui-card-body layui-row layui-col-space10">


                        <div class="layui-inline">
                            <input type="text" name="date" id="date" value="{:date('Y-m-d',strtotime('-61 day')) .' - '. date('Y-m-d',strtotime('00:00:00'))}" placeholder="时间" autocomplete="off" class="layui-input">
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

<script type="text/html" id="toolbar">
    <span class="layui-btn " onclick="$eb.createModalFrame(this.innerText,`{:url('ReCount')}`)" >重新统计</span>
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

    layui.use(['table','form','layer','laydate'], function () {
        var form = layui.form,table = layui.table,layer = layui.layer,laydate = layui.laydate;
        laydate.render({
            elem: '#date',
            range : true
        });
        var limit = 500;
        table.render({
            elem: '#table'
            ,defaultToolbar: [ 'print', 'exports']
            ,url: "{:url('getlist')}",
            cellMinWidth: 100 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
            ,method:'post'
            ,toolbar: '#toolbar'
            ,totalRow: true // 开启合计行
            ,height: 'full-30'
            ,limit: limit //每页默认显示的数量
            ,limits: [500,1000,2000,5000] //每页默认显示的数量
            ,page : true
            ,cols: [[
                {field: 'time', title: '时间', minWidth: 130,fixed: 'left'},
                {field: 'num', title: '当日用户数', minWidth: 130,fixed: 'left',templet:
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
                },
                //{field: 'day11', title: '11日留存', minWidth: 120},
                //{field: 'day12', title: '12日留存', minWidth: 120},
                //{field: 'day13', title: '13日留存', minWidth: 120},
                //{field: 'day14', title: '14日留存', minWidth: 120},
                {field: 'day15', title: '15日留存', minWidth: 120,templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.time}}`, 14)">{{ d.day15 }}</a></div>'
                },
                //{field: 'day16', title: '16日留存', minWidth: 120},
                // {field: 'day17', title: '17日留存', minWidth: 120},
                //{field: 'day18', title: '18日留存', minWidth: 120},
                //{field: 'day19', title: '19日留存', minWidth: 120},
                {field: 'day20', title: '20日留存', minWidth: 120,templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.time}}`, 19)">{{ d.day20 }}</a></div>'
                },
                //{field: 'day21', title: '21日留存', minWidth: 120},
                //{field: 'day22', title: '22日留存', minWidth: 120},
                //{field: 'day23', title: '23日留存', minWidth: 120},
                //{field: 'day24', title: '24日留存', minWidth: 120},
                {field: 'day25', title: '25日留存', minWidth: 120,templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.time}}`, 24)">{{ d.day25 }}</a></div>'
                },
                //{field: 'day26', title: '26日留存', minWidth: 120},
                //{field: 'day27', title: '27日留存', minWidth: 120},
                //{field: 'day28', title: '28日留存', minWidth: 120},
                //{field: 'day29', title: '29日留存', minWidth: 120},
                {field: 'day30', title: '30日留存', minWidth: 120,templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.time}}`, 29)">{{ d.day30 }}</a></div>'
                },
                {field: 'day45', title: '45日留存', minWidth: 120,templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.time}}`, 34)">{{ d.day35 }}</a></div>'
                },

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



