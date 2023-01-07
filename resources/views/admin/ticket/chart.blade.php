<style>
    .welcome .layui-card {border:1px solid #f2f2f2;border-radius:5px;}
    .welcome .icon {margin-right:10px;color:#1aa094;}
    .welcome .icon-cray {color:#ffb800 !important;}
    .welcome .icon-blue {color:#1e9fff !important;}
    .welcome .icon-tip {color:#ff5722 !important;}
    .welcome .layuimini-qiuck-module {text-align:center;margin-top:10px}
    .welcome .layuimini-qiuck-module a i {display:inline-block;width:100%;height:60px;line-height:60px;text-align:center;border-radius:2px;font-size:30px;background-color:#F8F8F8;color:#333;transition:all .3s;-webkit-transition:all .3s;}
    .welcome .layuimini-qiuck-module a cite {position:relative;top:2px;display:block;color:#666;text-overflow:ellipsis;overflow:hidden;white-space:nowrap;font-size:14px;}
    .welcome .welcome-module {width:100%;height:210px;}
    .welcome .panel {background-color:#fff;border:1px solid transparent;border-radius:3px;-webkit-box-shadow:0 1px 1px rgba(0,0,0,.05);box-shadow:0 1px 1px rgba(0,0,0,.05)}
    .welcome .panel-body {padding:10px}
    .welcome .panel-title {margin-top:0;margin-bottom:0;font-size:12px;color:inherit}
    .welcome .label {display:inline;padding:.2em .6em .3em;font-size:75%;font-weight:700;line-height:1;color:#fff;text-align:center;white-space:nowrap;vertical-align:baseline;border-radius:.25em;margin-top:.3em;}
    .welcome .layui-red {color:red}
    .welcome .main_btn > p {height:40px;}
    .welcome .layui-bg-number {background-color:#F8F8F8;}
</style>
<div class="layuimini-container layuimini-page-anim">
    <div class="layuimini-main welcome">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
                <div class="layui-row layui-col-space15">
                    <div class="layui-card">
                        <div class="layui-card-header"><i class="fa fa-line-chart icon"></i>今日申请数据</div>
                        <div class="layui-card-body">
                            <div id="echarts-day" style="width: 100%;min-height:300px"></div>
                        </div>
                    </div>
                </div>
                <div class="layui-row layui-col-space15" style="margin-top: 16px;">
                    <div class="layui-card">
                        <div class="layui-card-header"><i class="fa fa-line-chart icon"></i>历史总数据</div>
                        <div class="layui-card-body">
                            <div id="echarts-sum" style="width: 100%;min-height:300px"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    layui.use(['layer','echarts'], function () {
        var $ = layui.jquery,
            layer = layui.layer,
            echarts = layui.echarts;

        var echartsDay = echarts.init(document.getElementById('echarts-day'), 'walden');
        var optionRecords = {
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'cross',
                    label: {
                        backgroundColor: '#6a7985'
                    }
                }
            },
            legend: {
                data: <?php //echo json_encode($data['legend']); ?>
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            toolbox: {
                feature: {
                    saveAsImage: {}
                }
            },
            xAxis: {
                type: 'category',
                boundaryGap: false,
                data: <?php //echo json_encode($data['days_of_week']); ?>,
            },
            yAxis: {
                type: 'value'
            },
            series: <?php //echo json_encode($data['activity']); ?>
        };
        echartsDay.setOption(optionRecords);

        // echarts 窗口缩放自适应
        window.onresize = function () {
            echartsDay.resize();
        }

    });
</script>
