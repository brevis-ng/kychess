<div class="layuimini-main">
    <div class="layui-form layuimini-form">
        <div class="layui-form-item">
            <label class="layui-form-label required">{{ __('home.activity.title') }}</label>
            <div class="layui-input-block">
                <input type="text" name="title" lay-verify="required" class="layui-input"
                lay-reqtext="{{ __('validation.required', ['attribute' => __('home.activity.title')]) }}"
                placeholder="{{ __('home.activity.title') }}" value="{{ $activity->title }}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label required">{{ __('home.activity.forms') }}</label>
            <div class="layui-input-block">
                <input type="text" name="forms" lay-verify="required" class="layui-input"
                lay-reqtext="{{ __('validation.required', ['attribute' => __('home.activity.forms')]) }}"
                placeholder="{{ __('home.activity.forms') }}" value="{{ $activity->forms }}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label required">{{ __('home.activity.poster') }}</label>
            <input type="hidden" id="poster" name="poster" value="{{$activity->poster}}">
            <div class="layui-input-block">
                <div class="layui-upload">
                    <button type="button" class="layui-btn layui-btn-sm" id="uploadPoster">{{ __('home.upload.img') }}</button>
                    <div class="layui-upload-list">
                        <img class="layui-upload-img" id="demo" src="{{ asset($activity->poster) }}">
                        <p id="demoText"></p>
                    </div>
                </div>   
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">{{ __('home.sort') }}</label>
            <div class="layui-input-block">
                <input type="number" name="sort" class="layui-input" placeholder="{{ __('home.sort') }}" value="{{ $activity->sort }}">
                <tip>??????????????????????????????</tip>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label required">{{ __('home.activity.repeatable') }}</label>
            <div class="layui-input-block">
                <input type="checkbox" name="repeatable" lay-skin="switch"
                lay-text="{{ __('home.open') }}|{{ __('home.close') }}"
                id="repeatable" lay-filter="repeatable" @if($activity->repeatable) checked @endif>
            </div>
        </div>
        <div class="layui-form-item" id="repetition_name" @if($activity->repeatable) style="display:none" @endif>
            <label class="layui-form-label required">{{ __('home.activity.repetition_name') }}</label>
            <div class="layui-input-block">
                <input type="text" name="repetition_name" class="layui-input"
                placeholder="{{ __('home.activity.repetition_name') }}"
                value="{{ $activity->repetition_name }}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label required">{{ __('home.activity.active') }}</label>
            <div class="layui-input-block">
                <input type="checkbox" name="active" lay-skin="switch"
                lay-text="{{ __('home.active') }}|{{ __('home.inactive') }}"
                @if($activity->active) checked @endif>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label required">{{ __('home.activity.content') }}</label>
            <div class="layui-input-block">
                <textarea name="content" lay-verify="required" class="layui-textarea"
                lay-reqtext="{{ __('validation.required', ['attribute' => __('home.activity.content')]) }}"
                placeholder="{{ __('home.activity.content') }}">{{ $activity->content }}</textarea>
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
    layui.use(['form', 'upload', 'element'], function () {
        var form = layui.form,
            layer = layui.layer,
            element = layui.element,
            upload = layui.upload,
            $ = layui.$;
        /**
         * ????????????????????????????????????????????????????????????????????????
         */
        form.render();
        // ????????????????????????ID?????????
        var parentIndex = layer.index;
        //????????????
        form.on('submit(saveBtn)', function (data) {
            var index = layer.alert(
                "{{ __('home.edit.confirm') }}",
                {title: "{{ __('home.info') }}", btn: ["{{__('home.yes')}}", "{{__('home.cancel')}}"]},
                function () {
                    $.ajax({
                        url: "{{ route('activity.update', ['activity' => 'activityId']) }}".replace('activityId', "{{ $activity->id }}"),
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
                    // ???????????????
                    layer.close(index);
                }
            );
            return false;
        });

        // ??????input??????
        form.on('switch(repeatable)', function(data){
            if(!data.elem.checked) {
                $('#repetition_name').show();
            } else {
                $('#repetition_name').hide();
            }
        }); 

        // ????????????
        var uploadInst = upload.render({
            elem: '#uploadPoster',
            accept: 'images',
            acceptMime: 'image/*',
            exts: 'jpg|png|gif|bmp|jpeg|webp',
            field: 'picture',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            url: '{{ route("home.upload") }}',
            //????????????????????????????????????ie8
            before: function (obj) {
                obj.preview(function (index, file, result) {
                    $('#demo').attr('src', result); //???????????????base64???
                });
                layer.msg('{{ __("home.upload.loading") }}', {icon: 16, time: 0});
            },
            //??????????????????
            done: function (res) {
                if (res.code > 0) {
                    return layer.msg('{{ __("home.upload.no") }}');
                }
                //???????????????????????????
                $('#poster').val(res.path);
                layer.msg('{{ __("home.upload.done") }}', {icon: 1});
                $('#demoText').html('');
            },
            //????????????????????????????????????
            error: function () {
                var demoText = $('#demoText');
                demoText.html('<span style="color: #FF5722;">{{ __("home.upload.no") }}</span> <a class="layui-btn layui-btn-xs demo-reload">{{ __("home.retry") }}</a>');
                demoText.find('.demo-reload').on('click', function () {
                    uploadInst.upload();
                });
            },
        });
    });
</script>