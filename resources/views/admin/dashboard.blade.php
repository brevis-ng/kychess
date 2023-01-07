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
            <div class="layui-col-md8">
                <div class="layui-row layui-col-space15">
                    <div class="layui-col-md6">
                        <div class="layui-card">
                            <div class="layui-card-header"><i class="fa fa-warning icon"></i>{{ __('home.ticket.chart') }}</div>
                            <div class="layui-card-body">
                                <div class="welcome-module">
                                    <div class="layui-row layui-col-space10">
                                        <div class="layui-col-xs6">
                                            <div class="panel layui-bg-number">
                                                <div class="panel-body">
                                                    <div class="panel-title">
                                                        <h5>{{ __('home.ticket.total') }}</h5>
                                                    </div>
                                                    <div class="panel-content">
                                                        <h1 class="no-margins">{{ $data['all'] }}</h1>
                                                        <small>当前分类总记录数</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="layui-col-xs6">
                                            <div class="panel layui-bg-number">
                                                <div class="panel-body">
                                                    <div class="panel-title">
                                                        <h5>{{ __('home.ticket.all_accepted') }}</h5>
                                                    </div>
                                                    <div class="panel-content">
                                                        <h1 class="no-margins">{{ $data['all_accepted'] }}</h1>
                                                        <small>当前分类总记录数</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="layui-col-xs6">
                                            <div class="panel layui-bg-number">
                                                <div class="panel-body">
                                                    <div class="panel-title">
                                                        <h5>{{ __('home.ticket.all_rejected') }}</h5>
                                                    </div>
                                                    <div class="panel-content">
                                                        <h1 class="no-margins">{{ $data['all_rejected'] }}</h1>
                                                        <small>当前分类总记录数</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="layui-col-xs6">
                                            <div class="panel layui-bg-number">
                                                <div class="panel-body">
                                                    <div class="panel-title">
                                                        <h5>{{ __('home.ticket.all_bonus') }}</h5>
                                                    </div>
                                                    <div class="panel-content">
                                                        <h1 class="no-margins">{{ $data['all_bonus'] }}</h1>
                                                        <small>当前分类总记录数</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-col-md6">
                        <div class="layui-card">
                            <div class="layui-card-header"><i class="fa fa-credit-card icon icon-blue"></i>{{ __('home.menu') }}</div>
                            <div class="layui-card-body">
                                <div class="welcome-module">
                                    <div class="layui-row layui-col-space10 layuimini-qiuck">
                                        <div class="layui-col-xs3 layuimini-qiuck-module">
                                            <a href="javascript:;" layuimini-content-href="{{ route('admin.index') }}" data-title="{{ __('home.admin.index') }}" data-icon="fa fa-user">
                                                <i class="fa fa-user"></i>
                                                <cite>{{ __('home.admin.index') }}</cite>
                                            </a>
                                        </div>
                                        <div class="layui-col-xs3 layuimini-qiuck-module">
                                            <a href="javascript:;" layuimini-content-href="{{ route('roles.index') }}" data-title="{{ __('home.roles.index') }}" data-icon="fa fa-group">
                                                <i class="fa fa-group"></i>
                                                <cite>{{ __('home.roles.index') }}</cite>
                                            </a>
                                        </div>
                                        <div class="layui-col-xs3 layuimini-qiuck-module">
                                            <a href="javascript:;" layuimini-content-href="{{ route('permissions.index') }}" data-title="{{ __('home.permission.index') }}" data-icon="fa fa-gavel">
                                                <i class="fa fa-gavel"></i>
                                                <cite>{{ __('home.permission.index') }}</cite>
                                            </a>
                                        </div>
                                        <div class="layui-col-xs3 layuimini-qiuck-module">
                                            <a href="javascript:;" layuimini-content-href="{{ route('activity.index') }}" data-title="{{ __('home.activity.index') }}" data-icon="fa fa-puzzle-piece">
                                                <i class="fa fa-puzzle-piece"></i>
                                                <cite>{{ __('home.activity.index') }}</cite>
                                            </a>
                                        </div>
                                        <div class="layui-col-xs3 layuimini-qiuck-module">
                                            <a href="javascript:;" layuimini-content-href="{{ route('ticket.pending') }}" data-title="{{ __('home.ticket.index') }}" data-icon="fa fa-flag-checkered">
                                                <i class="fa fa-flag-checkered"></i>
                                                <cite>{{ __('home.ticket.index') }}</cite>
                                            </a>
                                        </div>
                                        <div class="layui-col-xs3 layuimini-qiuck-module">
                                            <a href="javascript:;" layuimini-content-href="{{ route('ticket.audited') }}" data-title="{{ __('home.ticket.audited') }}" data-icon="fa fa-check">
                                                <i class="fa fa-check"></i>
                                                <cite>{{ __('home.ticket.audited') }}</cite>
                                            </a>
                                        </div>
                                        <div class="layui-col-xs3 layuimini-qiuck-module">
                                            <a href="javascript:;" layuimini-content-href="{{ route('reply.index') }}" data-title="{{ __('home.reply.setting') }}" data-icon="fa fa-reply-all">
                                                <i class="fa fa-reply-all"></i>
                                                <cite>{{ __('home.reply.setting') }}</cite>
                                            </a>
                                        </div>
                                        <div class="layui-col-xs3 layuimini-qiuck-module">
                                            <a href="javascript:;" layuimini-content-href="page/layer.html" data-title="弹出层" data-icon="fa fa-shield">
                                                <i class="fa fa-shield"></i>
                                                <cite>弹出层</cite>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="layui-col-md12">
                        <div class="layui-card">
                            <div class="layui-card-header"><i class="fa fa-line-chart icon"></i>报表统计</div>
                            <div class="layui-card-body">
                                <div id="echarts-records" style="width: 100%;min-height:500px"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="layui-col-md4">
                <div class="layui-card">
                    <div class="layui-card-header"><i class="fa fa-fire icon"></i>{{ __('home.dashboard.systeminfo') }}</div>
                    <div class="layui-card-body layui-text">
                        <table class="layui-table">
                            <colgroup>
                                <col width="100">
                                <col>
                            </colgroup>
                            <tbody>
                                <tr>
                                    <td>{{ __('home.dashboard.domain') }}</td>
                                    <td>{{ config('app.url') }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('home.dashboard.port') }}</td>
                                    <td>{{ $_SERVER['SERVER_PORT'] }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('home.dashboard.engine') }}</td>
                                    <td>{{ $_SERVER['SERVER_SOFTWARE'] }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('home.dashboard.os') }}</td>
                                    <td>{{ php_uname('s').php_uname('r') }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('home.dashboard.php') }}</td>
                                    <td>{{ PHP_VERSION . ' ' . php_sapi_name() }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('home.dashboard.laravel') }}</td>
                                    <td>{{ app()::VERSION }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('home.dashboard.max_upload') }}</td>
                                    <td>{{ get_cfg_var("upload_max_filesize") ? get_cfg_var ("upload_max_filesize") : "不允许" }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="layui-card">
                    <div class="layui-card-header"><i class="fa fa-paper-plane-o icon"></i>作者心语</div>
                    <div class="layui-card-body layui-text layadmin-text"></div>
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
        /**
         * 报表功能
         */
        var echartsRecords = echarts.init(document.getElementById('echarts-records'), 'walden');
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
                data: <?php echo json_encode($data['legend']); ?>
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
                data: <?php echo json_encode($data['days_of_week']); ?>,
            },
            yAxis: {
                type: 'value'
            },
            series: <?php echo json_encode($data['activity']); ?>
        };
        echartsRecords.setOption(optionRecords);

        // echarts 窗口缩放自适应
        window.onresize = function () {
            echartsRecords.resize();
        }

    });
</script>
