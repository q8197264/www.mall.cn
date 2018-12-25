@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">商品展示</div>

                    @foreach ($data as $v)
                    @if ($v->stock > 0)

                    <div class="panel-body">
                        <div class="alert alert-success">
                            商品名：
                            <a href="/goods/{{$v->id}}/show" target="_blank">
                                {{ $v->goods_name }}
                            </a>
                              |  店铺：<a href="#">{{$v->shop_name}}</a>
                        </div>
                        <div>
                            <img width="100" src="{{$v->images}}">
                        </div>
                            品牌：{{$v->brand_name}}
                        <p style="color:gray">商品编号：{{$v->spu_no}}</p>
                        <p>
                            价格：<span style="color:red">{{$v->price}}</span>
                            库存:<span>{{$v->stock}}</span>
                        </p>
                            分类ID:{{$v->category_id}}
                    </div>
                    @endif
                    @endforeach

                </div>
            </div>
        </div>
    </div>
@endsection
