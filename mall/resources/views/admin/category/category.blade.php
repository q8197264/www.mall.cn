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
<div>
    <table>
        @foreach ($data as $val)
        <tr>
            <td>{{ $val['id'] }} {{ $val['type_id'] }} {{ $val['category_name'] }}</td>
        </tr>
        @endforeach
    </table>
    <h5>商品分类</h5>
    <form action="/admin/category" method="post">
        <input name="tid" type="number" placeholder="tid">
        <input name="cname" type="text" placeholder="cname">
        {{csrf_field()}}
        <input type="submit" value="add">
        <input type="reset" value="reset">
    </form>
    <form action="/admin/category" method="post">
        <input name="id" type="number" placeholder="id">
        <input name="tid" type="number" placeholder="tid">
        <input name="cname" type="text"  placeholder="cname">
        <input type="hidden" name="_method" value="PUT">
        {{csrf_field()}}
        <input type="submit" value="edit">
        <input type="reset" value="reset">
    </form>
    <form action="/admin/category" method="post">
        <input name="id" type="number" placeholder="id">
        <input type="hidden" name="_method" value="DELETE">
        {{csrf_field()}}
        <input type="submit" value="del">
        <input type="reset" value="reset">
    </form>
</div>
</body>
</html>
