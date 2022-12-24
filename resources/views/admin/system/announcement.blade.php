<div class="layuimini-main">
    <div class="layui-form layuimini-form">
        <div class="layui-form-item">
            <label class="layui-form-label required">{{ __('home.announcement.label') }}</label>
            <div class="layui-input-block">
                <textarea name="announcement" required lay-verify="required" class="layui-textarea"
                lay-reqtext="{{ __('validation.required', ['attribute' => __('home.announcement.set')]) }}"
                placeholder="{{ __('home.announcement.placeholder') }}">{{ $announcement }}</textarea>
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
            $ = layui.$;

        form.render();
        //监听提交
        form.on('submit(saveBtn)', function (data) {
            var index = layer.alert(
                "{{ __('home.edit.confirm') }}",
                {title: "{{ __('home.info') }}", btn: ["{{__('home.yes')}}", "{{__('home.cancel')}}"]},
                function () {
                    $.ajax({
                        url: "{{ route('system.announcement') }}",
                        type: 'PUT',
                        data: data.field,
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function (res) {
                            if (res.code == 200) {
                                layer.msg(res.msg, {icon:6, time:2000});
                            } else {
                                layer.msg(res.msg, {icon:5, time:2000})
                            }
                            location.reload();
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
                    layer.close(index);
                }
            );
            return false;
        });
    });
</script>