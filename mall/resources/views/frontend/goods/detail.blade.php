@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">商品展示</div>

                    @if (!empty($data))
                        <div class="panel-body">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    商品名：{{ $data['goods_name'] }}
                                </div>
                            @endif
                            品牌：{{ $data['brand_name'] }}
                            <p>
                                最低价格：{{$data['low_price']}}
                            </p>
                            分类:{{$data['category_name']}}
                                @foreach ($data['sku'] as $sku_id=>$sku)
                                    @foreach ($sku['spec'] as $spec)
                                        <div>{{$spec->spec_name}}:{{$spec->spec_value}}</div>
                                    @endforeach
                                    库存：{{$sku['stock']}}
                                    <p>
                                        {{$sku['sku_name']}}:{{$sku['price']}}
                                    </p>

                                    <form action="/carts" method="post">
                                        {{csrf_field()}}
                                        <input type="hidden"  name="spu_id" value="{{$data['id']}}">
                                        <input type="hidden" name="sku_id" value="{{$sku_id}}">
                                        <input type="hidden" name="shop_id" value="{{$sku['shop_id']}}">
                                        <input type="number" name="number" value="1"
                                               onkeyup="if( this.value > {{$sku['stock']}} ) {
                                                   this.value = {{$sku['stock']}}
                                               }"
                                        >
                                        <input type="submit" value="添加购物车">
                                    </form>
                                @endforeach

                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
