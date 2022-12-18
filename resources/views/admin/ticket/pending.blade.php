<div class="layuimini-container layuimini-page-anim">
    <div class="layuimini-main">
        <fieldset class="table-search-fieldset">
            <legend>{{ __('home.search_title') }}</legend>
            <div style="margin: 10px 10px 10px 10px">
                <form class="layui-form layui-form-pane" action="">
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label">{{ __('home.username') }}</label>
                            <div class="layui-input-inline">
                                <input type="text" name="username" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label">{{ __('home.ticket.activity') }}</label>
                            <div class="layui-input-inline">
                                <select name="activity_id">
                                    <option value="">{{ __('home.ticket.activity') }}</option>
                                    @foreach($activities as $activity)
                                    <option value="{{ $activity->id }}">{{ $activity->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="layui-inline">
                            <button type="submit" class="layui-btn layui-btn-primary" lay-submit lay-filter="data-search-btn"><i class="layui-icon"></i>{{ __('home.search') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </fieldset>

        <script type="text/html" id="toolbarDemo">
            <div class="layui-btn-container">
                <button class="layui-btn layui-btn-sm" id="exportBtn" lay-event="export"> {{ __('home.export.title') }} </button>
                <button class="layui-btn layui-btn-sm layui-btn-normal" lay-event="accept-all"> {{ __('home.accept.all') }} </button>
                <button class="layui-btn layui-btn-sm layui-btn-danger" lay-event="reject-all"> {{ __('home.reject.all') }} </button>
                <div class="layui-inline" style="font-size: 14px;display: none;" id="exportStatus"></div>
            </div>
        </script>

        <table class="layui-hide" id="currentTableId" lay-filter="currentTableFilter"></table>

        <script type="text/html" id="currentTableBar">
            @can('update', App\Models\Ticket::class)
            <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="accept">{{ __('home.ticket.accepted') }}</a>
            <a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="reject">{{ __('home.ticket.rejected') }}</a>
            @endcan
        </script>

        <script type="text/html" id="statusTpl">
            @{{#  if(d.status == 'pending'){ }}
            <span style="color: #FFB800;">{{ __('home.ticket.pending') }}</span>
            @{{#  } else if(d.status == 'accepted') { }}
            <span style="color: #5FB878;">{{ __('home.ticket.accepted') }}</span>
            @{{#  } else if(d.status == 'rejected') { }}
            <span style="color: #FF5722;">{{ __('home.ticket.rejected') }}</span>
            @{{#  } }}
        </script>
        <script type="text/html" id="titleTpl">
            @{{=d.activity.title}}
        </script>
        <script type="text/html" id="formTpl">
            <a href="javascript:;" id="@{{d.id}}" style="color:blue" lay-event="showData">{{ __('home.click_detail') }}</a>
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
            toolbar: '#toolbarDemo',
            defaultToolbar: ['filter', 'exports', 'print', {
                title: '提示',
                layEvent: 'LAYTABLE_TIPS',
                icon: 'layui-icon-tips'
            }],
            cols: [[
                {type: "checkbox", width: 50},
                {field: 'id', width: 100, title: 'ID', sort: true},
                {field: 'username', width: 120, title: '{{__("home.ticket.username")}}'},
                {field: 'activity', width: 220, title: '{{__("home.ticket.activity")}}', templet: '#titleTpl'},
                {field: 'data', width: 150, title: '{{__("home.ticket.data")}}', templet: '#formTpl'},
                {field: 'bonus', width: 120, title: '{{__("home.ticket.bonus")}}', edit:true},
                {field: 'ip_address', width:120, title: '{{__("home.ticket.ip")}}',},
                {field: 'created_at', width:180, title: '{{__("home.created_at")}}'},
                {field: 'status', width: 130, title: '{{__("home.status")}}', sort: true, templet: '#statusTpl'},
                {title: '{{__("home.action")}}', minWidth: 50, toolbar: '#currentTableBar', align: "center"}
            ]],
            limits: [20, 50, 100],
            limit: 20,
            page: true,
        });

        form.render();

        // 监听搜索操作
        form.on('submit(data-search-btn)', function (data) {
            var result = JSON.stringify(data.field);
            //执行搜索重载
            table.reload('currentTableId', {
                page: {
                    curr: 1
                },
                where: {
                    searchParams: result
                },
            }, 'data');

            return false;
        });

        /**
         * toolbar事件监听
         */
        table.on('toolbar(currentTableFilter)', function (obj) {
            if (obj.event === 'accept-all') {  // 监听删除操作
                var checkStatus = table.checkStatus('currentTableId');
                var data = checkStatus.data;
                var ids = [];
                for(var i=0; i<data.length; i++) {
                    ids.push(data[i]['id'])
                }
                layer.confirm(
                    "{{ __('home.accept.confirm') }}",
                    {title: "{{__('home.info')}}", btn: ["{{__('home.yes')}}", "{{__('home.cancel')}}"]},
                    function (index) {
                        $.ajax({
                            type: "PUT",
                            url: "{{ route('ticket.accept')}}",
                            data: {ids: ids},
                            dataType: "json",
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token(); }}'
                            },
                            success: function (response) {
                                if ( response.code == 200 ) {
                                    layer.msg(response.msg, {icon: 6, time: 3000})
                                    layer.close(index)
                                    location.reload();
                                } else {
                                    layer.msg(response.msg, {icon: 5, shift: 6, time: 2000});
                                }
                            }
                        });
                        layer.close(index);
                    }
                );
            } else if (obj.event === 'reject-all') {
                var checkStatus = table.checkStatus('currentTableId');
                var data = checkStatus.data;
                var ids = [];
                for(var i=0; i<data.length; i++) {
                    ids.push(data[i]['id'])
                }
                layer.confirm(
                    "{{ __('home.reject.confirm') }}",
                    {title: "{{__('home.info')}}", btn: ["{{__('home.yes')}}", "{{__('home.cancel')}}"]},
                    function (index) {
                        $.ajax({
                            type: "PUT",
                            url: "{{ route('ticket.reject')}}",
                            data: {ids: ids},
                            dataType: "json",
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token(); }}'
                            },
                            success: function (response) {
                                if ( response.code == 200 ) {
                                    layer.msg(response.msg, {icon: 6, time: 3000})
                                    layer.close(index)
                                    location.reload();
                                } else {
                                    layer.msg(response.msg, {icon: 5, shift: 6, time: 2000});
                                }
                            }
                        });
                        layer.close(index);
                    }
                );
            } else if (obj.event === 'export') {
                var content = miniPage.getHrefContent("{{ route('ticket.export', ['type' => 'options']) }}");
                var index = layer.open({
                    title: "{{ __('home.export.title') }}",
                    type: 1,
                    shade: 0.2,
                    maxmin:true,
                    shadeClose: true,
                    area: '500px',
                    offset: 'auto',
                    content: content,
                });
                $(window).on("resize", function () {
                    layer.full(index);
                });
            }
        });

        table.on('tool(currentTableFilter)', function (obj) {
            var data = obj.data;
            if (obj.event === 'edit') {

                var content = miniPage.getHrefContent("{{ route('permissions.edit', ['permission' => 'id']) }}".replace('id', data.id));
                var openWH = miniPage.getOpenWidthHeight();

                var index = layer.open({
                    title: "{{ __('home.permission.edit') }}",
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
                            url: "{{ route('permissions.destroy', ['permission' => 'permissionId']) }}".replace('permissionId', data.id),
                            dataType: "json",
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token(); }}'
                            },
                            success: function (response) {
                                if ( response.code == 200 ) {
                                    top.layer.msg(response.msg, {icon: 6, time:2000})
                                    layer.close(index)
                                    location.reload();
                                } else {
                                    layer.msg(response.msg, {icon: 5, shift: 6, time: 2000});
                                }
                            }
                        });
                        layer.close(index);
                    }
                );
            } else if (obj.event === 'showData') {
                var str = '';
                var dist = obj.data.data;
                for(index in dist) {
                    str += index + ' : ' + dist[index] + '<br>';
                }
                layer.tips(str, '#' + obj.data.id,{tips:1,time:0,closeBtn: 2,success: function () {
                    $(".layui-layer-content").css({'font-size':'16px'})
                    $(".layui-layer-tips .layui-layer-setwin").css({'top':'5px','right':'5px'}) //按钮位置 
                    $(".layui-layer-tips .layui-layer-setwin").html('<i class="layui-icon layui-layer-close1 layui-layer-close layui-icon-close" style="font-size: 20px; color:white;"></i>')//按钮样式
                }});
            }
        });
    });
</script>