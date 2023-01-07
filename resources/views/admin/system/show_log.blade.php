<div class="layuimini-container layuimini-page-anim">
    <div class="layuimini-main">
        <table class="layui-table">
            <tbody class="layui-table-body">
                <tr>
                    <td colspan="2" class="layui-bg-gray">{{ __('home.log.admin') }}</td>
                </tr>
                <tr>
                    <td>Date</td>
                    <td>{{ $log->created_at->format('d/m/y H:i') }} - {{ $log->created_at->diffForHumans() }}</td>
                </tr>
                <tr>
                    <td>{{__("home.log.admin")}}</td>
                    <td>{{ $log->user->username }}</td>
                </tr>
                <tr>
                    <td>{{__("home.log.type")}}</td>
                    <td>
                        <span style="font-weight: bold;text-transform: uppercase;" @class([
                            'layui-badge',
                            'layui-bg-blue' => $log->type == 'login',
                            'layui-bg-orange' => $log->type == 'edit',
                            'layui-bg-green' => $log->type == 'create',
                        ])>
                        {{ ucwords($log->type) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>{{__("home.log.model")}}</td>
                    <td>{{ ucwords($log->logable_type) }}</td>
                </tr>
                <tr>
                    <td>{{__("home.log.id")}}</td>
                    <td>{{ ucwords($log->logable_id) }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="layui-bg-black">
                        <p>{{ __('home.log.new_data') }}</p>
                    </td>
                </tr>
                @foreach ((Array) $log->new_data as $field => $data)
                @php
                    $new = is_array($data) ? json_encode($data) : $data;
                    $old = isset($log->old_data[$field]) ? is_array($log->old_data[$field]) ? json_encode($log->old_data[$field]) : $log->old_data[$field] : $new
                @endphp
                    <tr>
                        <td>{{ $field }}</td>
                        <td @if ($old !== $new) style="color: #FF5722;" @endif>{!!  $new !!}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2" class="layui-bg-black">
                        <p>{{ __('home.log.old_data') }}</p>
                    </td>
                </tr>
                @forelse ((Array) $log->old_data as $field => $data)
                @php
                    $old = is_array($data) ? json_encode($data) : $data;
                    $new = isset($log->new_data[$field]) ? is_array($log->new_data[$field]) ? json_encode($log->new_data[$field]) : $log->new_data[$field] : $old
                @endphp
                    <tr>
                        <td>{{ $field }}</td>
                        <td @if ($old !== $new) style="color: #FFB800;" @endif>{!!  $old !!}</td>
                    </tr>
                    @empty 
                    <tr>
                        <td colspan="2">No data available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>