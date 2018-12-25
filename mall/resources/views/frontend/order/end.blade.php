@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    @if ($data['code'] == 0)
                    <div class="panel-heading">交易完成</div>

                    @foreach ($data['data'] as $v)
                            <div class="panel-body">
                                订单流水：{{$v['order_sn']}}
                                <div class="alert alert-success">
                                    <a href="/orders/{{$v['order_id']}}/show" target="_blank">查看订单</a>
                                    <a href="/comment/{{$v['order_id']}}/show" target="_blank">去评价</a>
                                </div>
                            </div>
                    @endforeach


                    @else
                    <div class="panel-body">{{$data['msg']}}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
