@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <form action="/address" method="post">
                    {{csrf_field()}}
                    <div class="panel panel-default">
                        <div class="panel-heading">添加地址</div>
                        <div class="panel-body">
                            <div>
                                收货人姓名：<input type="text" name="name" placeholder="姓名">
                            </div>
                            <div>
                                <div>
                                    tel:<input type="number" name="tel" value="" placeholder="tel">
                                </div>
                                <div>
                                    phone:<input type="number" name="phone" value="" placeholder="phone">
                                </div>
                            </div>
                            <div>
                                选择地区 ：
                                <select name="province">
                                    <option>省</option>
                                    <option>1</option>
                                    <option>1</option>
                                </select>
                                <select name="city">
                                    <option>市</option>
                                    <option>1</option>
                                    <option>1</option>
                                </select>
                                <select name="district">
                                    <option>区</option>
                                    <option>1</option>
                                    <option>1</option>
                                </select>
                            </div>
                            <div>详细地址：<input type="text" name="address" placeholder="详细地址"></div>
                        </div>
                    </div>
                    <input type="submit" value="添加"/>
                </form>
            </div>
        </div>
    </div>
@endsection

<script>

</script>