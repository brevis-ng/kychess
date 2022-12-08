<div class="layuimini-container layuimini-page-anim">
    <div class="layuimini-main">

        <fieldset class="table-search-fieldset">
            <legend>{{ __('home.search_title') }}</legend>
            <div style="margin: 10px 10px 10px 10px">
                <form class="layui-form layui-form-pane" action="">
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label">{{ __('home.activity.title') }}</label>
                            <div class="layui-input-inline">
                                <input type="text" name="title" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <button type="submit" class="layui-btn layui-btn-primary"  lay-submit lay-filter="data-search-btn"><i class="layui-icon"></i>{{ __('home.search') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </fieldset>

        <script type="text/html" id="toolbarDemo">
            <div class="layui-btn-container">
                @can('create', App\Models\Activity::class)
                <button class="layui-btn layui-btn-normal layui-btn-sm data-add-btn" lay-event="add"> {{ __('home.add.title') }} </button>
                @endcan
                @can('delete', App\Models\Activity::class)
                <button class="layui-btn layui-btn-sm layui-btn-danger data-delete-btn" lay-event="delete"> {{ __('home.delete.title') }} </button>
                @endcan
            </div>
        </script>

        <table class="layui-hide" id="currentTableId" lay-filter="currentTableFilter"></table>

        <x-action-button :model="App\Models\Activity::class" ></x-action-button>

        <script type="text/html" id="statusTpl">
            @{{#  if(d.active){ }}
              <a href="javascript:;" style="color: #5FB878;" lay-event="chgstatus">{{ __('home.active') }}</a>
            @{{#  } else { }}
              <a href="javascript:;" style="color: #FF5722;" lay-event="chgstatus">{{ __('home.inactive') }}</a>
            @{{#  } }}
        </script>
        <script type="text/html" id="repeatableTpl">
            @{{#  if(d.repeatable){ }}
              <a href="javascript:;" style="color: #5FB878;" lay-event="chgstatus">{{ __('home.open') }}</a>
            @{{#  } else { }}
              <a href="javascript:;" style="color: #FF5722;" lay-event="chgstatus">{{ __('home.close') }}</a>
            @{{#  } }}
        </script>

    </div>
</div>
<script>
    layui.use(['form', 'table','miniPage','element'], function () {
        var $ = layui.jquery,
            form = layui.form,
            table = layui.table,
            miniPage = layui.miniPage;

        table.render({
            elem: '#currentTableId',
            url: '{{ route("activity.index") . "?type=menu" }}',
            toolbar: '#toolbarDemo',
            defaultToolbar: ['filter', 'exports', 'print', {
                title: '提示',
                layEvent: 'LAYTABLE_TIPS',
                icon: 'layui-icon-tips'
            }],
            cols: [[
                {type: "checkbox", width: 50},
                {field: 'id', width: 50, title: 'ID'},
                {field: 'title', width: 150, title: '{{__("home.activity.title")}}'},
                {field: 'forms', width: 150, title: '{{__("home.activity.forms")}}'},
                {field: 'poster', width: 200, title: '{{__("home.activity.poster")}}'},
                {field: 'repeatable', width: 180, title: '{{__("home.activity.repeatable")}}', sort: true, templet: '#repeatableTpl'},
                {field: 'active', width:150, title: '{{__("home.activity.active")}}', sort: true, templet: '#statusTpl'},
                {field: 'created_at', width: 150, title: '{{__("home.created_at") }}', sort: true},
                {title: '{{__("home.action")}}', minWidth: 50, toolbar: '#currentTableBar', align: "center"}
            ]],
            page: false,
        });

        // 监听搜索操作
        form.on('submit(data-search-btn)', function (data) {
            var result = JSON.stringify(data.field);
            //执行搜索重载
            table.reload('currentTableId', {
                page: {
                    curr: 1
                }
                , where: {
                    searchParams: result
                }
            }, 'data');

            return false;
        });

        /**
         * toolbar事件监听
         */
        table.on('toolbar(currentTableFilter)', function (obj) {
            if (obj.event === 'add') {   // 监听添加操作
                var content = miniPage.getHrefContent("{{ route('activity.create') }}");
                var openWH = miniPage.getOpenWidthHeight();

                var index = layer.open({
                    title: "{{ __('home.activity.create') }}",
                    type: 1,
                    shade: 0.2,
                    maxmin:true,
                    shadeClose: true,
                    area: [openWH[0] + 'px', openWH[1] + 'px'],
                    offset: [openWH[2] + 'px', openWH[3] + 'px'],
                    content: content,
                });
                $(window).on("resize", function () {
                    layer.full(index);
                });
            } else if (obj.event === 'delete') {  // 监听删除操作
                var checkStatus = table.checkStatus('currentTableId');
                var data = checkStatus.data;
                var ids = [];
                for(var i=0; i<data.length; i++) {
                    ids.push(data[i]['id'])
                }
                layer.confirm(
                    "{{ __('home.delete.confirm') }}",
                    {title: "{{__('home.info')}}", btn: ["{{__('home.yes')}}", "{{__('home.cancel')}}"]},
                    function (index) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('admin.destroy', ['admin' => 'adminId']) }}".replace('adminId', ids[0]),
                            data: {ids: ids},
                            dataType: "json",
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token(); }}'
                            },
                            success: function (response) {
                                if ( response.code == 200 ) {
                                    layer.msg(response.msg, {icon: 6, time:2000})
                                    layer.close(index)
                                    location.reload();
                                } else {
                                    layer.msg(response.msg, {icon: 5, shift: 6, time: 2000});
                                }
                            }
                        });
                        layer.close(index);
                    }
                );
            }
        });

        //监听表格复选框选择
        table.on('checkbox(currentTableFilter)', function (obj) {
            // console.log(obj)
        });

        table.on('tool(currentTableFilter)', function (obj) {
            var data = obj.data;
            if (obj.event === 'edit') {

                var content = miniPage.getHrefContent("{{ route('admin.edit', ['admin' => 'adminId']) }}".replace('adminId', data.id));
                var openWH = miniPage.getOpenWidthHeight();

                var index = layer.open({
                    title: "{{ __('home.admin.edit') }}",
                    type: 1,
                    shade: 0.2,
                    maxmin:true,
                    shadeClose: true,
                    area: [openWH[0] + 'px', openWH[1] + 'px'],
                    offset: [openWH[2] + 'px', openWH[3] + 'px'],
                    content: content,
                });
                $(window).on("resize", function () {
                    layer.full(index);
                });
                return false;
            } else if (obj.event === 'delete') {
                layer.confirm(
                    "{{ __('home.delete.confirm') }}",
                    {title: "{{__('home.info')}}", btn: ["{{__('home.yes')}}", "{{__('home.cancel')}}"]},
                    function (index) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('admin.destroy', ['admin' => 'adminId']) }}".replace('adminId', data.id),
                            dataType: "json",
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token(); }}'
                            },
                            success: function (response) {
                                if ( response.code == 200 ) {
                                    top.layer.msg(response.msg, {icon: 6, time:2000})
                                    layer.close(index)
                                    location.reload();
                                } else {
                                    layer.msg(response.msg, {icon: 5, shift: 6, time: 2000});
                                }
                            }
                        });
                        layer.close(index);
                    }
                );
            }
        });

    });
</script>