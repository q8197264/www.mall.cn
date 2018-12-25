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
<div>
    <h4>管理员登录 (已完成)</h4>
    <form action="/admin/administrator" method="post">
        <input name="id" type="text" value="1" disabled>
        <input type="hidden" name="_method" value="DELETE">
        {{csrf_field()}}
        <input type="submit" value="删除用户">(已完成)
    </form>
    <hr>
    <form action="/admin/checkLogin" method="post">
        <p><input name="uname" type="text" placeholder="user"></p>
        <p><input name="password" type="password"  placeholder="password"></p>
        {{csrf_field()}}
        <input type="submit" value="login">
        <input type="reset" value="reset">
    </form>
</div>
<div>
    <h4>Admin用户更新 (已完成)</h4>
    <form action="/admin/administrator" method="post">
        <input type="hidden" name="_method" value="PUT">
        <p><input name="id" type="text" value="2"></p>
        <p><input name="uname" type="text" placeholder="admin"></p>
        <p><input name="email" type="email" placeholder="email"></p>
        <p><input name="phone" type="number" placeholder="phone"></p>
        <p><input name="password" type="password"  placeholder="password"></p>
        <p><input name="password_confirmation" type="password"  placeholder="repassword"></p>
        {{csrf_field()}}
        <input type="submit" value="edit">
        <input type="reset" value="reset">
    </form>
</div>

<div>
    <h4>Admin用户注册 (已完成)</h4>
    <a href="/admin/administrator/1/show" target="_blank">获取用户(已完成)</a>
    <form action="/admin/administrator" method="post">
        <p><input name="uname" type="text" placeholder="admin"></p>
        {{--<p><input name="email" type="email" placeholder="email"></p>--}}
        {{--<p><input name="phone" type="number" placeholder="phone"></p>--}}
        <p><input name="password" type="password"  placeholder="password"></p>
        <p><input name="password_confirmation" type="password"  placeholder="repassword"></p>
        {{csrf_field()}}
        <input type="submit" value="register">
        <input type="reset" value="reset">
    </form>
</div>
</body>
</html>
