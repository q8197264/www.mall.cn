@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <div class="panel panel-default">
                    <div class="panel-heading">配送地址</div>
                    <form action="/address" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="PUT">
                    @foreach ($address as $row)
                        <div>{{$row->name}}</div>
                        <div>{{$row->phone}}</div>
                        <div>{{$row->tel}}</div>
                        <div>{{$row->address}}</div>
                        <div>{{$row->zipcode}}</div>
                        @if ($row->selected)
                            默认地址
                        @endif
                        <div>
                            <input type="submit" value="edit">
                        </div>
                    @endforeach
                    </form>

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
                        @foreach ($data as $row)
                            <div class="panel-body">
                                <div>
                                    配送方式:
                                    <select name="shipping">
                                        <option value="0">快递运输</option>
                                        <option value="0">EMS运输</option>
                                    </select>
                                </div>
                                <div class="alert alert-success">
                                    商品名：{{ $row->sku_name }}
                                </div>
                                <div style="float:left">
                                    <input type="checkbox" name="cart_id[]" value="{{$row->cart_id}}" checked="checked">
                                </div>
                                <div style="float:left">
                                    <img width="100" src="{{ $row->images }}">
                                </div>
                                <div style="float:left">
                                    @foreach ($row->spec as $p)
                                        <p>{{ $p->spec_name }}:{{ $p->spec_value }}</p>
                                    @endforeach
                                </div>
                                <div style="margin-left:200px">
                                    数量：
                                    <input style="width:45px" type="number"
                                           value="@if ($row->stock >= $row->spu_numbers){{$row->spu_numbers}}@else{{$row->stock}}@endif"
                                           onclick="">
                                </div>
                                <div style="float:right">
                                    <span>加入时价格:{{$row->add_price}}</span>
                                    单价：<span>{{$row->price}}</span>
                                    | <span style="color:red">{{ $row->price * $row->spu_numbers}}</span>
                                </div>
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