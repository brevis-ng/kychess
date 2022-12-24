<div class="layuimini-container layuimini-page-anim">
    <div class="layuimini-main">
        <script type="text/html" id="toolbarDemo">
            <div class="layui-btn-container">
                @can('create', App\Models\Reply::class)
                <button class="layui-btn layui-btn-normal layui-btn-sm data-add-btn" lay-event="add"> {{ __('home.reply.create') }} </button>
                @endcan
            </div>
        </script>
        <table class="layui-hide" id="currentTableId" lay-filter="currentTableFilter"></table>
        <script type="text/html" id="currentTableBar">
            @canany(['update', 'delete'], App\Models\Reply::class)
            <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="add">{{ __('home.edit.title') }}</a>
            <a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="delete">{{ __('home.delete.title') }}</a>
            @endcan
        </script>
    </div>
</div>
<script>
    layui.use(['form', 'table','miniPage','element'], function () {
        var $ = layui.jquery,
            table = layui.table,
            miniPage = layui.miniPage;

        table.render({
            elem: '#currentTableId',
            toolbar: '#toolbarDemo',
            url: '{{ route("reply.index") . "?type=menu" }}',
            cols: [[
                {field: 'id', title: 'ID', width: 60, sort: true},
                {field: 'content', title: '{{__("home.reply.content")}}'},
                {title: '{{__("home.action")}}', width: 200, toolbar: '#currentTableBar', align: "center"}
            ]],
        });

        // toolbar事件监听
        table.on('toolbar(currentTableFilter)', function (obj) {
            if (obj.event === 'add') {
                var content = miniPage.getHrefContent("{{ route('reply.create') }}");
                var openWH = miniPage.getOpenWidthHeight();

                var index = layer.open({
                    title: "{{ __('home.reply.create') }}",
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
            }
        });
        
        // 行按钮
        table.on('tool(currentTableFilter)', function (obj) {
            var data = obj.data;
            if (obj.event === 'add') {
                var content = miniPage.getHrefContent("{{ route('reply.edit', ['reply' => 'id']) }}".replace('id', data.id));
                var openWH = miniPage.getOpenWidthHeight();
                var index = layer.open({
                    title: "{{ __('home.reply.edit') }}",
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
                            url: "{{ route('reply.destroy', ['reply' => 'id']) }}".replace('id', data.id),
                            dataType: "json",
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token(); }}'
                            },
                            success: function (response) {
                                if ( response.code == 200 ) {
                                    top.layer.msg(response.msg, {icon: 6, time:2000})
                                    layer.close(index);
                                    table.reload('currentTableId');
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