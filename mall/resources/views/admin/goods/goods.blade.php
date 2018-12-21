<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>admin.goods</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <!-- Styles -->
</head>
<body style="margin-left: 25%">

<!--用户-->
<table border="1">
    <h4>展示商品 (已完成)</h4>
    <tr><td>商品ID</td><td>商品名</td><td>标签</td><td>价格/编号</td><td>SKU库存</td><td>上下架</td><td>操作</td></tr>
@foreach ($data as $v)
    <tr>
        <td rowspan="3">{{$v->id}}</td>
        <td>
            {{$v->goods_name}}
        </td>
        <td></td>
        <td>
            {{$v->low_price}}
        </td>
        <td rowspan="3">sku</td>
        <td rowspan="3">{{$v->sale}}</td>
        <td rowspan="3">
            <form action="admin/goods" method="post">
                <input type="hidden" name="_method" value="PUT">
                <input type="submit" value="edit">
            </form>
            <form action="admin/goods" method="post">
                <input type="hidden" name="_method" value="DELETE">
                <input type="submit" value="del">
            </form>
            <a href="/admin/goods/{{$v->id}}" target="_blank">show</a>
        </td>
    </tr>
    <tr><td>分类{{$v->category_id}}</td><td></td><td></td></tr>
    <tr><td>品牌{{$v->brand_name}}</td><td></td><td>{{$v->spu_no}}</td></tr>
@endforeach
</table>
    <div>
    <h4>添加商品 (已完成)</h4>
    <form action="/admin/goods" method="post">
        <p>商品名:<input name="gname" type="text" placeholder="goods_name"></p>
        <p>选择分类:
            <select name="cid">
                <option value="1">游戏</option>
                <option value="6">|--充值卡</option>
                <option value="8">|----仙剑三</option>
                <option value="7">|--游戏代练</option>
                <option value="2">TV</option>
                <option value="3">电器</option>
                <option value="4">家具</option>
                <option value="5">生鲜</option>
                <option value="9">数码产品</option>
                <option value="10">|--手机</option>
                <option value="11">|----iphone</option>
                <option value="12">|----vivo</option>
            </select>
        </p>
        <p>品牌:
            <select name="bid" >
                <option value="1">apple</option>
                <option value="2">huawei</option>
                <option value="3">vivo</option>
            </select>
        </p>
        <p>
            <input name="spec[]" type="checkbox" value="1" checked>颜色
            <select name="spec_value[1]">
                <option value="3">白</option>
                <option value="4">黑</option>
                <option value="5">红</option>
            </select>
            &nbsp|&nbsp
            <input name="spec[]" type="checkbox" value="2" checked>尺寸
            <select name="spec_value[2]">
                <option value="1">13寸</option>
                <option value="2">15寸</option>
            </select>
            &nbsp|&nbsp
            <input type="checkbox" value="">版本
        </p>
        <p>内容:<input name="description" type="text" placeholder="描述"></p>
        <p>套餐:<input name="sku_name" type="text" placeholder="官方标配"></p>
        <p>价格:<input name="lprice" type="number"  placeholder="low_price"></p>
        <p>店铺:<input name="shopid" type="number"  placeholder="店铺"></p>
        <p>库存:<input name="stock" type="number"  placeholder="库存"></p>
        {{csrf_field()}}
        <input type="submit" value="add">
        <input type="reset" value="reset">
    </form>
</div>
<div>
    <form>
        <p>spec</p>
        <p>规格:<input name="spec" type="text" placeholder="goods_name"></p>
        <p>规格值:<input name="gname" type="text" placeholder="goods_name"></p>

        <p>sku</p>
        <p>价格:<input name="gname" type="text" placeholder="goods_name"></p>
        <p>库存:<input name="gname" type="text" placeholder="goods_name"></p>
    </form>
</div>
<hr>
<div>
    <h4>更新商品info</h4>
    <form action="/admin/goods" method="post">
        <input type="hidden" name="_method" value="PUT">
        <p><input name="id" type="number" placeholder="id" value="1"></p>
        <p>商品名:<input name="gname" type="text" placeholder="goods_name"></p>

        <p>选择分类:
            <select name="cid">
                <option value="1">游戏</option>
                <option value="6">|--充值卡</option>
                <option value="8">|----仙剑三</option>
                <option value="7">|--游戏代练</option>
                <option value="2">TV</option>
                <option value="3">电器</option>
                <option value="4">家具</option>
                <option value="5">生鲜</option>
                <option value="9">数码产品</option>
                <option value="10">|--手机</option>
                <option value="11">|----iphone</option>
                <option value="12">|----vivo</option>
            </select>
        </p>
        <p>品牌:
            <select name="bid" >
                <option>apple</option>
                <option>apple</option>
                <option>apple</option>
            </select>
        </p>

        <p>
            <span>颜色</span>
            <select>
                <option>红</option>
                <option>白</option>
                <option>蓝</option>
            </select>
        </p>
        <p>
            <span>尺寸</span>
            <select>
                <option>13寸</option>
                <option>15寸</option>
            </select>
        <p>套餐:<input name="sku_name" type="number" placeholder="套餐：1,2,3,4"></p>
        <p>价格:<input name="lprice" type="number"  placeholder="low_price"></p>
        <p>店铺:<input name="spec_value" type="number"  placeholder="店铺"></p>
        <p>库存:<input name="stock" type="number"  placeholder="库存"></p>
        {{csrf_field()}}
        <input type="submit" value="update">
        <input type="reset" value="reset">
    </form>
</div>
<hr>
<div>
    <h4>删除商品(未完成)</h4>
    <form action="/admin/goods" method="post">
        <input name="id" type="text" value="1">
        <input type="hidden" name="_method" value="DELETE">
        {{csrf_field()}}
        <input type="submit" value="删除商品">
    </form>
</div>
</body>
</html>
