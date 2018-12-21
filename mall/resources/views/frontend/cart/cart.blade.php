@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <form action="/orders" method="post">
                    {{csrf_field()}}
                <div class="panel panel-default">
                    <div class="panel-heading">购物车</div>
                    @foreach ($data as $row)
                        <div class="panel-body">
                            <div class="alert alert-success">
                                商品名：{{ $row->sku_name }}
                            </div>
                            <div style="float:left">
                                <input type="checkbox" name="cart_id[]" id="{{$row->cart_id}}" value="{{$row->cart_id}}" onclick="check(this)">
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
                    </div>
                <input type="submit" value="结算"/>
                </form>
            </div>
        </div>
    </div>
@endsection

<script>
function check(e)
{
    console.log(e);
    var _token = $('input[name="_token"]').val();
    $.ajax({
        url:'carts/selected',
        method:'put',
        dataType:'json',
        data:{'id':e.id,'checked':e.checked,'_token':_token},
        success: function(data){
            console.log(data);
        },
        error:function (e){

        }
    });
}
</script>