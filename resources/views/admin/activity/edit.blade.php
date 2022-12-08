<div class="layuimini-main">
    <div class="layui-form layuimini-form">
        <div class="layui-form-item">
            <label class="layui-form-label required">{{ __('home.username') }}</label>
            <div class="layui-input-block">
                <input type="text" name="username" lay-verify="required" class="layui-input"
                lay-reqtext="{{ __('validation.required', ['attribute' => __('home.username')]) }}"
                placeholder="{{ __('home.username') }}" 
                value="{{ $user->username }}">
                <tip>填写自己管理账号的名称。</tip>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label required">{{ __('home.name') }}</label>
            <div class="layui-input-block">
                <input type="text" name="name" lay-verify="required" class="layui-input"
                lay-reqtext="{{ __('validation.required', ['attribute' => __('home.name')]) }}"
                placeholder="{{ __('home.name') }}"
                value="{{ $user->name }}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label required">{{ __('home.password') }}</label>
            <div class="layui-input-block">
                <input type="password" name="password" lay-verify="required" class="layui-input"
                lay-reqtext="{{ __('validation.required', ['attribute' => __('home.password')]) }}"
                placeholder="{{ __('home.password') }}"
                value="{{ $user->password }}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">{{ __('home.status') }}</label>
            <div class="layui-input-block">
                <input type="checkbox" name="status" lay-skin="switch"
                lay-text="{{ __('home.active') }}|{{ __('home.inactive') }}"
                @if($user->status) checked @endif>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">{{ __('home.role') }}</label>
            <div class="layui-input-block">
                <select name="role_id">
                    <option value=""></option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" @if($user->role_id == $role->id) selected @endif >{{ $role->name }}</option>
                    @endforeach
                </select>
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
                        url: "{{ route('admin.update', ['admin' => 'adminId']) }}".replace('adminId', "{{ $user->id }}"),
                        type: 'PUT',
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
                    layer.close(index);
                    layer.close(parentIndex);
                }
            );
            return false;
        });
    });
</script>