@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">发表评价</div>
                    @foreach ($list as $goods)
                    <div class="panel-body">
                        <img width="50" src="{{$goods->sku_images}}">
                        <div class="alert alert-success">
                            <form action="/comment" method="post">
                                {{csrf_field()}}
                                <textarea name="content" >
                                </textarea>

                            </form>
                        </div>

                        <div>

                            <h3 id="menu-image">图像接口</h3>

                            <span class="desc">拍照或从手机相册中选图接口</span>
                            <button class="btn btn_primary" id="chooseImage">chooseImage</button>
                            <div id="thumbnail">

                            </div>

                            <span class="desc">预览图片接口</span>
                            <button class="btn btn_primary" id="previewImage">previewImage</button>

                            <span class="desc">上传图片接口</span>
                            <button class="btn btn_primary" id="uploadImage">uploadImage</button>

                            <span class="desc">下载图片接口</span>
                            <button class="btn btn_primary" id="downloadImage">downloadImage</button>
                        </div>

                    </div>
                    @endforeach


                </div>
            </div>
        </div>
    </div>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.4.0.js"></script>
    <script>
        wx.config({
            // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，
            // 参数信息会通过log打出，仅在pc端时才会打印
            debug: true,
            appId: "{{$config['appid']}}",
            timestamp: "{{$config['timestamp']}}",
            nonceStr: "{{$config['noncestr']}}",
            signature: "{{$config['signature']}}",
            jsApiList: [
                // 所有要调用的 API 都要加到这个列表中
                'chooseImage',// 'onMenuShareTimeline',
                'uploadImage',
                'downloadImage',
                // 'checkJsApi',
                'previewImage'
            ]
        });
        wx.ready(function () {
            // 在这里调用 API

        });

        wx.error(function(res){
            // config信息验证失败会执行error函数，如签名过期导致验证失败，
            // 具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，
            // 对于SPA可以在这里更新签名。
            //console.log(res);
            alert("验证失败，请重试！");
            wx.closeWindow();
        });
    </script>
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
@endsection

