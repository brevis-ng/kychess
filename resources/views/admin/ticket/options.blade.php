<div class="layuimini-main">
    <div class="layui-form">
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">{{ __('home.created_at') }}</label>
                <div class="layui-input-inline" style="width: 120px;">
                    <input type="text" name="date-from" id="dateFrom" lay-verify="date" placeholder="yyyy-MM-dd" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid">-</div>
                <div class="layui-input-inline" style="width: 120px;">
                    <input type="text" name="date-to" id="dateTo" lay-verify="date" placeholder="yyyy-MM-dd" autocomplete="off" class="layui-input">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">{{ __('home.status') }}</label>
            <div class="layui-input-block">
                <input type="checkbox" name="status[pending]" title="{{__('home.ticket.pending')}}" checked="">
                <input type="checkbox" name="status[accepted]" title="{{__('home.ticket.accepted')}}">
                <input type="checkbox" name="status[rejected]" title="{{__('home.ticket.rejected')}}">
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-normal" lay-submit lay-filter="saveBtn">{{ __('home.export.title') }}</button>
            </div>
        </div>
    </div>
</div>
<script>
    layui.use(['form', 'laydate',], function () {
        var form = layui.form,
            layer = layui.layer,
            laydate = layui.laydate,
            $ = layui.$;

        /**
         * 初始化表单，要加上，不然刷新部分组件可能会不加载
         */
        form.render();
        // 当前弹出层，防止ID被覆盖
        var parentIndex = layer.index;
        //日期
        laydate.render({
            elem: '#dateFrom'
        });
        //日期
        laydate.render({
            elem: '#dateTo'
        });
        //监听提交
        form.on('submit(saveBtn)', function (data) {
            $.ajax({
                url: "{{ route('ticket.export') }}",
                type: 'GET',
                data: data.field,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (res) {
                    if (res.code == 200) {
                        layer.msg(res.msg, {icon:6, time:2000});
                        location.reload();
                    } else {
                        layer.msg(res.msg, {icon:5, time:2000})
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.responseJSON.errors.length !== 0) {
                        var errors = jqXHR.responseJSON.errors;
                        var attribute = '';
                        var message = '';
                        $.each(errors, function (attr, msgs) { 
                            attribute = attr;
                            message = msgs.join(',');
                        });
                        layer.msg(message, {icon: 5, shift: 6});
                    }
                }
            });
            // 关闭弹出层
            layer.close(parentIndex);
        });
    });
</script>