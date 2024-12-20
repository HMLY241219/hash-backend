<div class="layui-fluid" style="text-align: center">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="layui-card-body">
                <table class="layui-table">
                    <tbody>
                    <tr>
                        <td>游戏期数</td>
                        <td>{$info.issue}</td>
                        <td>开始时间</td>
                        <td>{:date('Y-m-d H:i:s',$info.begin_time)}</td>
                    </tr>
                    <tr>
                        <td>服务器种子</td>
                        <td>{$info.seed}</td>
                        <td>结束时间</td>
                        <td>{:date('Y-m-d H:i:s',$info.end_time)}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>