<div class="layuimini-container layuimini-page-anim">
    <div class="layuimini-main">
        <table class="layui-hide" id="shortcutTable" lay-filter="shortcutTableFilter"></table>
        <script type="text/html" id="shortcutTableBar">
            <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="chooseShortcut">{{ __('home.shortcut.select') }}</a>
        </script>
    </div>
</div>
<script>
    layui.use(['table', 'element'], function () {
        var $ = layui.jquery,
            layer = layui.layer,
            table = layui.table;

        var parentIndex = layer.index;
        table.render({
            elem: '#shortcutTable',
            url: '{{ route("home.get-shortcut") }}',
            cols: [[
                {field: 'text', title: '{{__("home.ticket.shortcut")}}'},
                {title: '{{__("home.action")}}', width: 100, toolbar: '#shortcutTableBar', align: "center"}
            ]],
            page: false,
            even: true,
            id: 'shortcutTableId'
        });
        table.on('tool(shortcutTableFilter)', function (obj) {
            var data = obj.data;
            if (obj.event === 'chooseShortcut') {
                $.ajax({
                    type: "PUT",
                    url: "{{ route('ticket.update') }}",
                    data: {
                        'id': '{{ $rowId }}',
                        'message': data.text,
                    },
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token(); }}'
                    },
                    success: function (response) {
                        if (response.code == 200) {
                            table.reload('currentTableId');
                            layer.msg(response.msg, {icon:6, time:2000});
                        } else {
                            layer.msg(response.msg, {icon:5, time:2000});
                        }
                        layer.close(parentIndex);
                    }
                });
            }
        });
    });
</script>