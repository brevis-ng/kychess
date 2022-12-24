<div class="layuimini-main">
    <div class="layui-form layuimini-form">
        <div class="layui-form-item">
            <label class="layui-form-label required">{{ __('home.reply.content') }}</label>
            <div class="layui-input-block">
                <textarea name="content" required lay-verify="required" class="layui-textarea"
                lay-reqtext="{{ __('validation.required', ['attribute' => __('home.reply.content')]) }}"
                placeholder="{{ __('home.reply.content') }}">{{ $reply->content }}</textarea>
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-normal" lay-submit lay-filter="saveBtn">{{ __('home.save') }}</button>
            </div>
        </div>
    </div>
</div>
<script>
    layui.use(['form', 'table'], function () {
        var form = layui.form,
            layer = layui.layer,
            table = layui.table,
            $ = layui.$;

        /**
         * 初始化表单，要加上，不然刷新部分组件可能会不加载
         */
        form.render();
        // 当前弹出层，防止ID被覆盖
        var parentIndex = layer.index;
        //监听提交
        form.on('submit(saveBtn)', function (data) {
            var index = layer.alert(
                "{{ __('home.edit.confirm') }}",
                {title: "{{ __('home.info') }}", btn: ["{{__('home.yes')}}", "{{__('home.cancel')}}"]},
                function () {
                    $.ajax({
                        url: "{{ route('reply.update', ['reply' => 'id']) }}".replace('id', "{{ $reply->id }}"),
                        type: 'PUT',
                        data: data.field,
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function (res) {
                            if (res.code == 200) {
                                table.reload('currentTableId');
                                layer.msg(res.msg, {icon:6, time:2000});
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
                    layer.close(index);
                    layer.close(parentIndex);
                }
            );
            return false;
        });
    });
</script>