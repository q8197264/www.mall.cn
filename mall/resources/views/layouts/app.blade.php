<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>mall</title>

    <!-- Styles -->
    <link href="{{ asset('mall/public/css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('mall/public/js/app.js') }}"></script>
</body>
</html>

{{--<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>--}}

<script>


    // 5 图片接口
    // 5.1 拍照、本地选图
    var images = {
        localId : [],
        serverId : []
    };

    //选择图片
    document.querySelector('#chooseImage').onclick = function () {
        wx.chooseImage({
            count: 9, // 默认9
            sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
            sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
            success: function (res) {
                images.localId = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
                console.log('已选择 ' + res.localIds.length + ' 张图片');

                for (var index in images.localId ){
                    var mg = "<img width='30' src='"+images.localId[index]+"'>";
                    document.querySelector('#thumbnail').innerHTML += mg;
                }

                //可同时上传到微信服务器
                //wx.uploadImage()...
            }
        });
    };


    // 5.3 上传图片
    document.querySelector('#uploadImage').onclick = function ()
    {
        if (images.localId.length == 0) {
            alert('请先使用 chooseImage 接口选择图片');
            return;
        }

        var i = 0, length = images.localId.length;
        images.serverId = [];
        function upload() {
            wx.uploadImage({
                localId: images.localId[i],// 需要上传的图片的本地ID，由chooseImage接口获得
                isShowProgressTips: 1,// 默认为1，显示进度提示
                success: function (res) {
                    i++;//递归自增,依次把localId传给微信后台, 并依次返回相应serverId
                    alert('已上传：' + i + '/' + length);
                    images.serverId.push(res.serverId);//返回图片的服务器端ID push 入images.serverId数组

                    if (i < length) {
                        upload();//递归上传
                    }else {
                        //上传完成后调用ajax把serverId(MedId)上传到后台
                        uploadToQiniu();
                    }
                },
                fail: function (res) {
                    console.log(JSON.stringify(res));
                }
            });
        }
        upload();
    };

    //人微信服务器保存到七牛云服务
    function uploadToQiniu()
    {
        if (images.serverId.length<1) {
            return false;
        }
        $.ajax({
            type : "post",
            url : "/comment",
            dataType : "json",
            async : false,
            data:{
                // staffId:staffid,
                _token:"{{csrf_token()}}",
                mediaIds:images.serverId,
                // sessionid:sessionid,
                // type:'post'
            },
            success : function(data) {
                alert(data);
                // for (var i in data) {
                //     alert(i);
                //     alert(data[i]);
                // }
            },
            error: function(xhr, status, error) {
                console.log("ajax error:",error);
            }
        });
    }


    // 5.2 图片预览(放大) == 未使用
    document.querySelector('#previewImage').onclick = function () {
        wx.previewImage({
            // 当前显示图片的http链接
            current: 'https://www.baidu.com/img/xinshouye_a99f407fdcfdee6fa81e1a31f000ea07.png',
            // 需要预览的图片http链接列表
            urls: [
                'https://www.baidu.com/img/xinshouye_a99f407fdcfdee6fa81e1a31f000ea07.png',
                'http://img5.douban.com/view/photo/photo/public/p1353993776.jpg',
                'http://img3.douban.com/view/photo/photo/public/p2152134700.jpg'
            ]
        });
    };

    // 5.4 下载图片 ==== 未使用
    document.querySelector('#downloadImage').onclick = function () {
        if (images.serverId.length === 0) {
            alert('请先使用 uploadImage 上传图片');
            return;
        }
        var i = 0, length = images.serverId.length;
        images.localId = [];
        function download() {
            wx.downloadImage({
                serverId: images.serverId[i],
                success: function (res) {
                    i++;
                    alert('已下载：' + i + '/' + length);
                    images.localId.push(res.localId);
                    if (i < length) {
                        download();
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);
                },
            });
        }
        download();
    };

    //删除同类型的其他兄弟节点
    function deleteBrotherEle(obj){
        obj.nextAll().remove();
    }

</script>