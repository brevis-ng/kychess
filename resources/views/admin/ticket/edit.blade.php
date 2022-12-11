<div class="layuimini-main">
    <div class="layui-form layuimini-form">
        <div class="layui-form-item">
            <label class="layui-form-label required">{{ __('home.permission.pid') }}</label>
            <div class="layui-input-block">
                <select name="pid">
                    <option value=""></option>
                    @foreach($permissions as $p)
                        <option value="{{ $p->id }}" @if($p->id == $permission->pid) selected @endif>{{ $p->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label required">{{ __('home.permission.title') }}</label>
            <div class="layui-input-block">
                <input type="text" name="title" lay-verify="required" class="layui-input"
                lay-reqtext="{{ __('validation.required', ['attribute' => __('home.permission.title')]) }}"
                placeholder="{{ __('home.permission.title') }}"
                value="{{ $permission->title }}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">{{ __('home.permission.href') }}</label>
            <div class="layui-input-block">
                <input type="text" name="href" class="layui-input"
                placeholder="{{ __('home.permission.href') }}"
                value="{{ $permission->href }}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">{{ __('home.permission.icon') }}</label>
            <div class="layui-input-block">
                <input type="text" name="icon" id="iconPicker" lay-filter="iconPicker" class="hide">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label required">{{ __('home.permission.level') }}</label>
            <div class="layui-input-block">
                <input type="number" name="level" lay-verify="required" class="layui-input"
                lay-reqtext="{{ __('validation.required', ['attribute' => __('home.permission.level')]) }}"
                placeholder="{{ __('home.permission.level') }}"
                value="{{ $permission->level }}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">{{ __('home.status') }}</label>
            <div class="layui-input-block">
                <input type="checkbox" name="status" lay-skin="switch"
                lay-text="{{ __('home.active') }}|{{ __('home.inactive') }}"
                @if($permission->status) checked @endif>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label required">{{ __('home.action') }}</label>
            <div class="layui-input-block">
                <input type="text" name="action" lay-verify="required" class="layui-input"
                lay-reqtext="{{ __('validation.required', ['attribute' => __('home.action')]) }}"
                placeholder="{{ __('home.action') }}"
                value="{{ $permission->action }}">
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
    layui.use(['form', 'table', 'iconPickerFa'], function () {
        var form = layui.form,
            layer = layui.layer,
            table = layui.table,
            iconPickerFa = layui.iconPickerFa,
            $ = layui.$;
        
        // Icon
        iconPickerFa.render({
            elem: '#iconPicker',
            url: "{{ asset('layuimini/lib/font-awesome-4.7.0/less/variables.less') }}",
            search: true,
            page: false,
            click: function (data) {
                console.log(data);
            },
            success: function (d) {
                console.log(d);
            }
        });
        iconPickerFa.checkIcon('iconPicker', '{{ $permission->icon }}');

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
                        url: "{{ route('permissions.update', ['permission' => 'id']) }}".replace('id', "{{ $permission->id }}"),
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