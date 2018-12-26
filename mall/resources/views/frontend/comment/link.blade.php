@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">评价商品</div>
                    @foreach ($list as $goods)
                    <div class="panel-body">
                        {{$goods->shop_name}}
                        <div class="alert alert-success">
                            <div><img width="100" src="{{$goods->images}}"></div>
                            <div>
                                <h5>{{$goods->sku_name}}</h5>
                            <span style="color:gray">{{$goods->sku_price}}</span>
                            </div>
                            查看订单
                            <a href="/comment/{{$goods->order_id}}/order/{{$goods->sku_id}}/todo">评价</a>
                        </div>

                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
