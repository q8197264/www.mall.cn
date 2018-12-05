<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

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
    <h5>分类</h5>
    <form action="/admin/categories" method="post">
        <input name="pid" type="number" placeholder="pid">
        <input name="name" type="text" placeholder="name">
        {{csrf_field()}}
        <input type="submit" value="add">
        <input type="reset" value="reset">
    </form>
    <form action="/admin/categories" method="post">
        <input name="cid" type="number" placeholder="cid">
        <input name="name" type="text"  placeholder="name">
        <input type="hidden" name="_method" value="PUT">
        {{csrf_field()}}
        <input type="submit" value="edit">
        <input type="reset" value="reset">
    </form>
    <form action="/admin/categories" method="post">
        <input name="cid" type="number" placeholder="cid">
        <input type="hidden" name="_method" value="DELETE">
        {{csrf_field()}}
        <input type="submit" value="del">
        <input type="reset" value="reset">
    </form>
</div>


<!--用户-->
<div>
    <h4>管理员登录</h4>
    <form action="/admin/login" method="post">
        <p><input name="uname" type="text" placeholder="user"></p>
        <p><input name="password" type="password"  placeholder="password"></p>
        {{csrf_field()}}
        <input type="submit" value="login">
        <input type="reset" value="reset">
    </form>
</div>

<div>
    <h4>Admin后台添加用户</h4>
    <form action="/admin/users" method="post">
        <p><input name="uname" type="text" placeholder="user"></p>
        {{--<p><input name="email" type="email" placeholder="email"></p>--}}
        {{--<p><input name="phone" type="number" placeholder="phone"></p>--}}
        <p><input name="password" type="password"  placeholder="password"></p>
        <p><input name="password_confirmation" type="password"  placeholder="repassword"></p>
        {{csrf_field()}}
        <input type="submit" value="register">
        <input type="reset" value="reset">
    </form>
</div>

<div>
    <h4>用户注册</h4>
    <form action="/admin/users" method="post">
        {{--<p><input name="uname" type="text" placeholder="user"></p>--}}
        {{--<p><input name="email" type="email" placeholder="email"></p>--}}
        <p><input name="phone" type="number" placeholder="phone"></p>
        <p><input name="password" type="password"  placeholder="password"></p>
        <p><input name="password_confirmation" type="password"  placeholder="repassword"></p>
        {{csrf_field()}}
        <input type="submit" value="register">
        <input type="reset" value="reset">
    </form>
</div>

</body>
</html>
