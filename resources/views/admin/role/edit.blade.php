<div class="layuimini-main">
    <div class="layui-form layuimini-form">
        <div class="layui-form-item">
            <label class="layui-form-label required">{{ __('home.roles.name') }}</label>
            <div class="layui-input-block">
                <input type="text" name="name" lay-verify="required" class="layui-input"
                lay-reqtext="{{ __('validation.required', ['attribute' => __('home.roles.name')]) }}"
                placeholder="{{ __('home.roles.name') }}"
                value="{{ $role->name }}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">{{ __('home.roles.desc') }}</label>
            <div class="layui-input-block">
                <input type="text" name="description" class="layui-input"
                placeholder="{{ __('home.roles.desc') }}"
                value="{{ $role->description }}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label required">{{ __('home.roles.permission') }}</label>
            <div class="layui-input-block">
                <div id="tree"></div>
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
    layui.use(['form', 'tree'], function () {
        var form = layui.form,
            tree = layui.tree,
            $ = layui.$;

        /**
         * 初始化表单，要加上，不然刷新部分组件可能会不加载
         */
        form.render();
        // 当前弹出层，防止ID被覆盖
        var parentIndex = layer.index;
        //监听提交
        form.on('submit(saveBtn)', function (data) {
            var permissions = [];
            var menu = [];
            var index = layer.alert(
                "{{ __('home.edit.confirm') }}",
                {title: "{{ __('home.info') }}", btn: ["{{__('home.yes')}}", "{{__('home.cancel')}}"]},
                function () {
                    getChecked(tree.getChecked('permissionId'), item => {
                        if(!item['children'] || item['level'] == 1) {
                            permissions.push(item.id); 
                        }
                        if(item['level'] < 2) {
                            menu.push(item.id)
                        }
                    });
                    $.ajax({
                        url: "{{ route('roles.update', ['role' => 'roleId']) }}".replace('roleId', "{{ $role->id }}"),
                        type: 'PUT',
                        data: {
                            "name" : data.field['name'],
                            "description" : data.field['description'],
                            "permission_ids" : permissions.join(','),
                            "menu_ids" : menu.join(','),
                        },
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

        // Permission Tree
        tree.render({
            elem: '#tree',
            data: JSON.parse('{!! $tree_data !!}'),
            showCheckbox: true,
            id: 'permissionId',
        });

        // Get checked permission
        function getChecked(jsonObj, callbackFunc) {
            if (!jsonObj) return;
            jsonObj.forEach(child => {
                callbackFunc(child);
                if (child.children) {
                    getChecked(child.children, callbackFunc);
                }
            });
        };
    });
</script>