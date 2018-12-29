<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>admin</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body style="margin-left: 25%">

<!--用户-->
<table border="1">
    <h4>销售报表 (已完成)</h4>
    <tr><td>订单编号</td><td>商品名</td><td>销量</td>
    @foreach ($data as $v)
        <tr>
            <td>{{$v->order_no}}</td>
            <td>
                {{$v->sku_name}}
            </td>
            <td>
                {{$v->number}}
            </td>
        </tr>
    @endforeach
</table>

<div>
    <h4>报表下载(已完成)</h4>
    <form action="/admin/report" method="post">
        {{csrf_field()}}
        <input type="submit" value="下载">
    </form>
</div>
</body>
</html>
