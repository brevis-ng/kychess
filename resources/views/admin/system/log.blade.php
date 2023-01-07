<div class="layuimini-container layuimini-page-anim">
    <div class="layuimini-main">
        <fieldset class="table-search-fieldset">
            <legend>{{ __('home.search_title') }}</legend>
            <div style="margin: 10px 10px 10px 10px">
                <form class="layui-form layui-form-pane" action="">
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label">{{ __('home.username') }}</label>
                            <div class="layui-input-inline">
                                <select name="user_id">
                                    <option value="">{{ __('home.ticket.activity') }}</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->username }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label">{{ __('home.created_at') }}</label>
                            <div class="layui-input-inline" style="width: 120px;">
                                <input type="text" name="dateFrom" id="dateFrom" placeholder="yyyy-MM-dd" autocomplete="off" class="layui-input">
                            </div>
                            <div class="layui-form-mid">-</div>
                            <div class="layui-input-inline" style="width: 120px;">
                                <input type="text" name="dateTo" id="dateTo" placeholder="yyyy-MM-dd" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <button type="submit" class="layui-btn layui-btn-primary" lay-submit lay-filter="data-search-btn"><i class="layui-icon"></i>{{ __('home.search') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </fieldset>

        <table class="layui-hide" lay-size="lg" id="currentTableId" lay-filter="currentTableFilter"></table>
        <script type="text/html" id="currentTableBar">
            <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="show">{{ __('home.log.show') }}</a>
        </script>
        <script type="text/html" id="userTpl">
            @{{=d.user.username}}
        </script>
        <script type="text/html" id="typeTpl">
            @{{#  if(d.type == 'login'){ }}
            <span class="layui-badge layui-bg-blue" style="font-weight: bold;text-transform: uppercase;">@{{ d.type }}</span>
            @{{#  } else if(d.type == 'edit') { }}
            <span class="layui-badge layui-bg-orange" style="font-weight: bold;text-transform: uppercase;">@{{ d.type }}</span>
            @{{#  } else if(d.type == 'delete') { }}
            <span class="layui-badge" style="font-weight: bold;text-transform: uppercase;">@{{ d.type }}</span>
            @{{#  } else if(d.type == 'create') { }}
            <span class="layui-badge layui-bg-green" style="font-weight: bold;text-transform: uppercase;">@{{ d.type }}</span>
            @{{#  } else { }}
            <span class="layui-badge layui-bg-cyan" style="font-weight: bold;text-transform: uppercase;">@{{ d.type }}</span>
            @{{#  } }}
        </script>
    </div>
</div>
<script>
    layui.use(['form', 'table','laydate','element','miniPage'], function () {
        var $ = layui.jquery,
            form = layui.form,
            table = layui.table,
            miniPage = layui.miniPage,
            laydate = layui.laydate;

        table.render({
            elem: '#currentTableId',
            url: '{{ route("system.log") . "?type=menu" }}',
            defaultToolbar: ['filter', 'exports', 'print', {
                title: '提示',
                layEvent: 'LAYTABLE_TIPS',
                icon: 'layui-icon-tips'
            }],
            cols: [[
                {field: 'id', width: 60, title: 'ID', sort: true},
                {field: 'user_id', title: '{{__("home.log.admin")}}', templet: '#userTpl'},
                {field: 'type', title: '{{__("home.log.type")}}', templet: '#typeTpl'},
                {field: 'logable_type', title: '{{__("home.log.model")}}'},
                {field: 'logable_id', title: '{{__("home.log.id")}}'},
                {field: 'created_at', title: '{{__("home.created_at")}}'},
                {title: '{{__("home.action")}}', toolbar: '#currentTableBar', align: "center"}
            ]],
            limits: [20, 50, 100],
            limit: 20,
            page: true,
        });

        form.render();

        //日期
        laydate.render({
            elem: '#dateFrom'
        });
        //日期
        laydate.render({
            elem: '#dateTo'
        });

        // 监听搜索操作
        form.on('submit(data-search-btn)', function (data) {
            var result = JSON.stringify(data.field);
            //执行搜索重载
            table.reload('currentTableId', {
                page: {
                    curr: 1
                },
                where: {
                    searchParams: result
                },
            }, 'data');

            return false;
        });

        table.on('tool(currentTableFilter)', function (obj) {
            var data = obj.data;
            if (obj.event === 'show') {
                // alert(data.id);
                var index = layer.open({
                    title: "{{ __('home.log.show') }}",
                    type: 1,
                    shade: 0.2,
                    maxmin:true,
                    shadeClose: true,
                    area: ['60%', '60%'],
                    offset: 'auto',
                    content: miniPage.getHrefContent("{{ route('system.show-log', ['id' => 'logId']) }}".replace('logId', data.id)),
                });
                $(window).on("resize", function () {
                    layer.full(index);
                });
                return false;
            };
        });
    });
</script>