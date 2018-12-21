@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">商品展示</div>

                    @foreach ($data as $v)
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                商品名：<a href="/goods/{{$v->id}}" target="_blank">{{ $v->goods_name }}</a>
                            </div>
                        @endif
                            品牌：{{$v->brand_name}} | 销量：{{$v->sale}}
                        <p style="color:gray">商品编号：{{$v->spu_no}}</p>
                        <p>
                            价格：<span style="color:red">{{$v->low_price}}</span>
                        </p>
                            分类ID:{{$v->category_id}}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
