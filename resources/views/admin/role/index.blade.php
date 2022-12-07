<div class="layuimini-container layuimini-page-anim">
    <div class="layuimini-main">
        <script type="text/html" id="toolbarDemo">
            <div class="layui-btn-container">
                @can('create', App\Models\Role::class)
                <button class="layui-btn layui-btn-normal layui-btn-sm data-add-btn" lay-event="add"> {{ __('home.add.title') }} </button>
                @endcan
                @can('delete', App\Models\Role::class)
                <button class="layui-btn layui-btn-sm layui-btn-danger data-delete-btn" lay-event="delete"> {{ __('home.delete.title') }} </button>
                @endcan
            </div>
        </script>

        <table class="layui-hide" id="currentTableId" lay-filter="currentTableFilter"></table>

        <x-action-button :model="App\Models\Role::class" ></x-action-button>
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
            url: '{{ route("roles.index") . "?type=menu" }}',
            toolbar: '#toolbarDemo',
            defaultToolbar: ['filter', 'exports', 'print', {
                title: '提示',
                layEvent: 'LAYTABLE_TIPS',
                icon: 'layui-icon-tips'
            }],
            cols: [[
                {type: "checkbox", width: 50},
                {field: 'id', width: 60, title: 'ID', sort: true},
                {field: 'name', width: 180, title: '{{__("home.roles.name")}}'},
                {field: 'description', width: 400, title: '{{__("home.roles.desc")}}'},
                {field: 'created_at', width: 180, title: '{{ __("home.created_at") }}', sort: true},
                {field: 'updated_at', width: 180, title: '{{ __("home.updated_at") }}', sort: true},
                {title: '{{__("home.action")}}', minWidth: 50, toolbar: '#currentTableBar', align: "center"}
            ]],
            page: false,
        });

        /**
         * toolbar事件监听
         */
        table.on('toolbar(currentTableFilter)', function (obj) {
            if (obj.event === 'add') {   // 监听添加操作
                var content = miniPage.getHrefContent("{{ route('roles.create') }}");
                var openWH = miniPage.getOpenWidthHeight();

                var index = layer.open({
                    title: "{{ __('home.roles.create') }}",
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
                if (ids.length == 0) {
                    layer.msg("{{ __('home.not_selected') }}", {icon: 5, shift: 6});
                    return false;
                }
                layer.confirm(
                    "{{ __('home.delete.confirm') }}",
                    {title: "{{__('home.info')}}", btn: ["{{__('home.yes')}}", "{{__('home.cancel')}}"]},
                    function (index) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('roles.destroy', ['role' => 'roleId']) }}".replace('roleId', ids[0]),
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
                            url: "{{ route('roles.destroy', ['role' => 'roleId']) }}".replace('roleId', data.id),
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