@extends('admin.layouts.app')

@section('content')

    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 反馈管理 <span
                class="c-gray en">&gt;</span> 反馈列表 <a class="btn btn-success radius r btn-refresh"
                                                      style="line-height:1.6em;margin-top:3px"
                                                      href="javascript:location.replace(location.href);" title="刷新"
                                                      onclick="location.replace('{{URL::asset('admin/feedback/index')}}');"><i
                    class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">
        <div class="text-c">
            <form id="search_form"  action="{{URL::asset('admin/feedback/index')}}" method="post" class="form-horizontal">
                {{csrf_field()}}
                <div class="Huiform text-r">
                    <span class="">用户id：</span>
                    <input id="user_id" name="user_id" type="text" class="input-text" style="width:200px"
                           placeholder="用户id" value="{{$con_arr['user_id']?$con_arr['user_id']:''}}">
                    <span class="ml-5">业务：</span>
                    <span class="select-box" style="width: 150px;">
                        <select id="busi_name" name="busi_name" class="select">
                            <option value="">请选择</option>
                            @foreach(\App\Components\Utils::BUSI_NAME_VAL as $key=>$value)
                                <option value="{{$key}}" {{$con_arr['busi_name']==strval($key)?'selected':''}}>{{$value}}</option>
                            @endforeach
                        </select>
                    </span>

                    <button type="submit" class="btn btn-success" id="" name="">
                        <i class="Hui-iconfont">&#xe665;</i> 搜索
                    </button>
                </div>
            </form>
        </div>
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="r">共有数据：<strong>{{$datas->total()}}</strong> 条</span>
        </div>
        <table class="table table-border table-bordered table-bg table-sort mt-10">
            <thead>
            <tr>
                <th scope="col" colspan="7">反馈列表</th>
            </tr>
            <tr class="text-c">
                {{--<th width="25"><input type="checkbox" name="" value=""></th>--}}
                <th width="20">ID</th>
                <th width="50">用户</th>
                <th width="20">业务</th>
                <th width="240">反馈详情</th>
                <th width="40">反馈时间</th>
                <th width="40">处理状态</th>
                <th width="40">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($datas as $data)
                <tr class="text-c">
                    {{--<td><input type="checkbox" value="1" name=""></td>--}}
                    <td>{{$data->id}}</td>
                    <td>
                        <span class="c-primary">{{$data->user->nick_name}}({{$data->user->id}})</span>
                    </td>
                    <td><span class="c-primary">{{$data->busi_name_str}}</span></td>
                    <td>
                        <div>
                            {{$data->content}}
                        </div>
                        @if($data->img_arr)
                            <div class="mt-10">
                                @foreach($data->img_arr as $img)
                                    <img src="{{$img}}?imageView2/2/w/300/interlace/1/q/75">
                                @endforeach
                            </div>
                        @endif
                    </td>
                    <td>{{$data->created_at}}</td>
                    <td><span class="c-primary">{{$data->status_str}}</span></td>
                    <td>暂无</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="mt-20">
            {{ $datas->appends($con_arr)->links() }}
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">


    </script>
@endsection