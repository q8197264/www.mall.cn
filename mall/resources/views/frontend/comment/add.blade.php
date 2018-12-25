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
@endsection
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