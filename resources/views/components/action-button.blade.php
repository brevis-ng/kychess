@props(['model'])

<script type="text/html" id="currentTableBar">
    @can('update', $model)
    <a class="layui-btn layui-btn-xs layui-btn-normal data-count-edit" lay-event="edit">{{ __('home.edit.title') }}</a>
    @endcan
    @can('delete', $model)
    <a class="layui-btn layui-btn-xs layui-btn-danger data-count-delete" lay-event="delete">{{ __('home.delete.title') }}</a>
    @endcan
</script>