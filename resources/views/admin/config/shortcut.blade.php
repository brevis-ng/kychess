<div class="layuimini-container layuimini-page-anim">
    <div class="layuimini-main">
        <table class="layui-hide" id="currentTableId" lay-filter="currentTableFilter"></table>
        <script type="text/html" id="currentTableBar">
            @can('update', App\Models\Ticket::class)
            <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="accept">{{ __('home.ticket.accepted') }}</a>
            <a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="reject">{{ __('home.ticket.rejected') }}</a>
            @endcan
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
            url: '{{ route("ticket.pending") . "?type=menu" }}',
            cols: [[
                {field: 'id', width: 60, title: 'ID', sort: true},
                {field: 'username', title: '{{__("home.ticket.username")}}'},
                {title: '{{__("home.action")}}', minWidth: 180, toolbar: '#currentTableBar', align: "center"}
            ]],
        });

        form.render();

        // 直接修改
        table.on('edit(currentTableFilter)', function (obj) {
            console.log(obj.field);
        });
        
        // 行按钮
        table.on('tool(currentTableFilter)', function (obj) {
            var data = obj.data;
            if (obj.event === 'accept') {
                var content = miniPage.getHrefContent("{{ route('permissions.edit', ['permission' => 'id']) }}".replace('id', data.id));
                var index = layer.open({
                    title: "{{ __('home.permission.edit') }}",
                    type: 1,
                    shade: 0.2,
                    maxmin:true,
                    shadeClose: true,
                    area: ['600px', '350px'],
                    offset: 'auto',
                    content: content,
                });
                $(window).on("resize", function () {
                    layer.full(index);
                });
                return false;
            }
        });
    });
</script>