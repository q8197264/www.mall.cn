@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <div class="panel panel-default">
                    <div class="panel-heading">配送地址</div>

                        <div>
                            <a href="/address/show">添加地址</a>
                            </form>
                        </div>
                    @foreach ($address as $row)
                        <form action="/address" method="post">
                            {{csrf_field()}}
                            <input type="hidden" name="_method" value="PUT">
                        <div>姓名：{{$row->name}} | 手机：{{$row->phone}} |座机：{{$row->tel}}</div>
                        <div>地址：{{$row->address}}
                            @if ($row->selected)
                                &nbsp&nbsp&nbsp&nbsp<span>默认地址</span>
                            @else
                                <a href="/address/{{$row->id}}/checked">设为默认地址</a>
                            @endif
                        </div>
                        <div>邮编：{{$row->zipcode}} | <input type="submit" value="编辑地址"></div>
                        </form>
                        <div style="float:right">
                            <form action="/address" method="post">
                                {{csrf_field()}}
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="id" value="{{$row->id}}">
                                <input type="submit" value="删除地址">
                            </form>
                        </div>
                    @endforeach



                    <form action="/orders" method="post">
                        {{csrf_field()}}
                        <div class="panel-heading">
                            <div>
                                <hr>
                                支付方式：
                                <select name="pay_mode">
                                    <option value="0">货到付款</option>
                                    <option value="1">在线支付</option>
                                </select>
                            </div>
                            <div>
                                <hr>送货清单
                            </div>
                        </div>
                        @foreach ($data as $shop)
                            <div class="panel-body">
                                <div>
                                    配送方式:
                                    <select name="shipping">
                                        <option value="0">快递运输</option>
                                        <option value="0">EMS运输</option>
                                    </select>
                                </div>
                                @foreach ($shop['cart_goods'] as $goods)
                                <div class="alert alert-success">
                                    商品名：{{ $goods->sku_name }}
                                </div>
                                <div style="float:left">
                                    <input type="checkbox" name="cart_id[]" value="{{$goods->cart_id}}" checked="checked">
                                </div>
                                <div style="float:left">
                                    <img width="100" src="{{ $goods->images }}">
                                </div>
                                <div style="float:left">
                                    @foreach ($goods->spec as $p)
                                        <p>{{ $p->spec_name }}:{{ $p->spec_value }}</p>
                                    @endforeach
                                </div>
                                <div style="margin-left:200px">
                                    数量：
                                    <input style="width:45px" type="number"
                                           value="@if ($goods->stock >= $goods->spu_numbers){{$goods->spu_numbers}}@else{{$row->stock}}@endif"
                                           onclick="">
                                </div>
                                <div style="float:right">
                                    <span>加入时价格:{{$goods->add_price}}</span>
                                    单价：<span>{{$goods->price}}</span>
                                    | <span style="color:red">{{ $goods->price * $goods->spu_numbers}}</span>
                                </div>
                                @endforeach
                            </div>
                        @endforeach
                        <hr>
                        <div style="width:100%;text-align:right"><input type="submit" value="提交订单"/></div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

<script>

</script>