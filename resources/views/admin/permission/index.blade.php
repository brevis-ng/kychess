<div class="layuimini-container layuimini-page-anim">
    <div class="layuimini-main">
        <script type="text/html" id="toolbarDemo">
            <div class="layui-btn-container">
                @can('create', App\Models\Permission::class)
                <button class="layui-btn layui-btn-normal layui-btn-sm data-add-btn" lay-event="add"> {{ __('home.add.title') }} </button>
                @endcan
                @can('delete', App\Models\Permission::class)
                <button class="layui-btn layui-btn-sm layui-btn-danger data-delete-btn" lay-event="delete"> {{ __('home.delete.title') }} </button>
                @endcan
            </div>
        </script>

        <table class="layui-hide" id="currentTableId" lay-filter="currentTableFilter"></table>

        <x-action-button :model="App\Models\Permission::class" ></x-action-button>

        <script type="text/html" id="statusTpl">
            @{{#  if(d.status){ }}
            <span style="color: #5FB878;">{{ __('home.active') }}</span>
            @{{#  } else { }}
            <span style="color: #FF5722;">{{ __('home.inactive') }}</span>
            @{{#  } }}
        </script>
        <script type="text/html" id="iconTpl">
            @{{# if(d.icon){ }}
            <i class="@{{ d.icon }}" ></i>
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
            url: '{{ route("permissions.index") . "?type=menu" }}',
            toolbar: '#toolbarDemo',
            defaultToolbar: ['filter', 'exports', 'print', {
                title: '提示',
                layEvent: 'LAYTABLE_TIPS',
                icon: 'layui-icon-tips'
            }],
            cols: [[
                {type: "checkbox", width: 50},
                {field: 'id', width: 60, title: 'ID', sort: true},
                {field: 'title', width: 180, title: '{{__("home.permission.title")}}'},
                {field: 'icon', width: 120, title: '{{__("home.permission.icon")}}', templet: '#iconTpl'},
                {field: 'href', width: 300, title: '{{__("home.permission.href")}}'},
                {field: 'level', width: 150, title: '{{__("home.permission.level")}}', sort: true},
                {field: 'status', width:100, title: '{{__("home.status")}}', templet: '#statusTpl'},
                {field: 'action', width: 180, title: '{{__("home.action")}}', sort: true},
                {title: '{{__("home.action")}}', minWidth: 50, toolbar: '#currentTableBar', align: "center"}
            ]],
            limit: 100,
        });

        /**
         * toolbar事件监听
         */
        table.on('toolbar(currentTableFilter)', function (obj) {
            if (obj.event === 'add') {   // 监听添加操作
                var content = miniPage.getHrefContent("{{ route('permissions.create') }}");
                var openWH = miniPage.getOpenWidthHeight();

                var index = layer.open({
                    title: "{{ __('home.permission.create') }}",
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
                            url: "{{ route('permissions.destroy', ['permission' => 'permissionId']) }}".replace('permissionId', ids[0]),
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

        table.on('tool(currentTableFilter)', function (obj) {
            var data = obj.data;
            if (obj.event === 'edit') {

                var content = miniPage.getHrefContent("{{ route('permissions.edit', ['permission' => 'id']) }}".replace('id', data.id));
                var openWH = miniPage.getOpenWidthHeight();

                var index = layer.open({
                    title: "{{ __('home.permission.edit') }}",
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
                            url: "{{ route('permissions.destroy', ['permission' => 'permissionId']) }}".replace('permissionId', data.id),
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