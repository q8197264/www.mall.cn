/**
 *




 {{--<button id="btn" style="margin-top: 200px;margin-left: 100px;">上传</button>--}}
 {{--<div id="pic"></div>--}}




 * @type {HTMLElement}
 */
var chooseImage = document.getElementById('chooseImage');
alert(chooseImage);
if(getCookie('imgsrc')){
    chooseImage.html('<img width="100%" height="100%" src="'+getCookie('imgsrc')+'" id="expImg">')
}

chooseImage.click(function(){
    wx.chooseImage({
        count: 1, // 默认9
        sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
        sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
        success: function (res) {
            images.localId = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
            if (images.localId.length == 0) {
                alert('请先使用 chooseImage 接口选择图片');
                return false;
            }
            if(images.localId.length > 1) {
                alert('目前仅支持单张图片上传,请重新上传');
                images.localId = [];
                return false;
            }

            var i = 0, length = images.localId.length;
//                        images.serverId = [];

            $imgsrc=images.localId[0];
            $.cookie('imgsrc', images.localId[0]);
            $("#chooseImage").html('<img width="100%" height="100%" src="'+$imgsrc+'" id="expImg">')

            function upload() {
                wx.uploadImage({
                    localId: images.localId[i],
                    isShowProgressTips: 1, // 默认为1，显示进度提示
                    success: function (res) {
                        i++;
                        //                                  that.siblings('img.preview').attr('src',images.localId[0]);
                        //                          alert('已上传：' + i + '/' + length);
                        images.serverId.push(res.serverId);
                        //                          that.siblings('input[type=hidden]').val(images.serverId[0]);
                        $("#mediaid").val(images.serverId[0]);
//                                    alert(images.serverId[0])
                        if (i < length) {
                            upload();
                        }
                    },
                    fail: function (res) {
                        alert(JSON.stringify(res));
                    }
                });
            }
            upload();
        }
    });
});

$(function(){

    $("#btn1").click(function(){
        $("#myinfo").val($("#myinfo2").val());
    })

    $("#btn2").click(function(){

        if($("#tname").val()==''){
            alert('请输入姓名！');
            $("#tname").focus();
            return false;
        }
        var mobile=$("#mobile").val()
        var rp = /^1[3|5|8|7|9][0-9]\d{8,8}|147[0-9]\d{7,7}|170[0-9]\d{7,7}$/;
        if (!rp.test(mobile) || mobile.length != 11) {
            alert("请输入格式正确的手机号码");
            $("#mobile").val("");
            $("#mobile").focus();
            return false;
        }
        if($("#myinfo").val()==''){
            alert('请输入自我介绍！');
            return false;
        }
        if($("#mediaid").val()==''){
            alert('请输入上传个人照片！');
            return false;
        }


        //创建FormData对象
        var datas = new FormData();
        //为FormData对象添加数据

        datas.append('action', 'add');
        datas.append('tname', $("#tname").val());
        datas.append('mobile', $("#mobile").val());
        datas.append('myinfo', $("#myinfo").val());
        datas.append('cartype', '1');
        datas.append('mediaid', $("#mediaid").val());

        $.ajax({
            type: 'post',
            async: false,
            url: 'deal.php',
            contentType: false,    //不可缺
            processData: false,    //不可缺
            data: datas,
//            dataType: "html",
            success: function (data, status) {
                alert(data);
                window.location.reload();
            },
            error: function (data, status, e) {
                console.log("系统异常" + data + e);
            }
        });
    })
});


function setCookie(name,value)
{
    var Days = 30;
    var exp = new Date();
    exp.setTime(exp.getTime() + Days*24*60*60*1000);
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}
function getCookie(name)
{
    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");

    if(arr=document.cookie.match(reg))

        return unescape(arr[2]);
    else
        return null;
}
//删除cookies
function delCookie(name)
{
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var cval=getCookie(name);
    if(cval!=null)
        document.cookie= name + "="+cval+";expires="+exp.toGMTString();
}

//多图上传，有bug
function testbak1(){
// <p>最多可添加9张作品</p>
//     <input type="file" id="uploadphoto" name="uploadfile" value="请点击上传图片"   style="display:none;" />
//         <div class="imglist"></div>
//         <input type="hidden" id="img_str" name="img_str">
//         <a id="upload_button" href="javascript:void(0);" class="uploadImage uploadbtn">
//         <img width="50" src="{{$goods->sku_images}}" alt=""></a>
//         <div class="sb">发布</div>

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
        wx.checkJsApi({
            jsApiList: [
                'getNetworkType',
                'chooseImage',
                'uploadImage'
            ],
            success: function (res) {
                //console.log(JSON.stringify(res));
                //alert(JSON.stringify(res));
                //alert(JSON.stringify(res.checkResult.getLocation));
                if (res.checkResult.getLocation == false) {
                    alert('你的微信版本太低，不支持微信JS接口，请升级到最新的微信版本！');
                    return;
                }else{
                    // wxChooseImage();
                }
            }
        });


        $('.uploadImage').on('click', function () {
            wx.chooseImage({
                success: function (res) {
                    var localIds = res.localIds;
                    syncUpload(localIds);
                }
            });
        });
        wx.error(function(res){
            // config信息验证失败会执行error函数，如签名过期导致验证失败，
            // 具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，
            // 对于SPA可以在这里更新签名。
            //console.log(res);
            alert("验证失败，请重试！");
            wx.closeWindow();
        });

        var images = {
            localId: [],
            serverId: []
        };


        var syncUpload = function(localIds){
            var localId = localIds.pop();
            wx.uploadImage({
                localId: localId,
                isShowProgressTips: 1,
                success: function (res) {
                    var serverId = res.serverId; // 返回图片的服务器端ID
                    console.log('serverId===='+serverId);
                    var str = $('#img_str').val()+serverId+',';
                    $('.imglist').append("<img src='"+localId+"' />");
                    $('#img_str').val(str);
                    //其他对serverId做处理的代码
                    if(localIds.length > 0){
                        syncUpload(localIds);
                    }

                    // if($('.imglist img').size() >= 9) {
                    //     $("#upload_button").hide();
                    // }
                },
                fail: function (res) { alert(JSON.stringify(res)); }
            });
        };
    });

}


//单张上传.无bug
function test2{
    /**
     <form action="/comment"  method="post">
     <h3 class="title">参赛人员照片：</h3>
     <div>
     <img class="preview" src="" alt="">
     {{--<if condition="!$vote['status']" >--}}
     <button class="uploadImage" type="button" id="vote_pic">
     点击上传（建议上传800*600的png,jpg,或者gif格式图片）</button>
     {{--</if>--}}
     <input type="hidden" name="vote_pic">
     </div>
     <button class="bbon" type="submit" id="submit">提交</button>
     </form>
     */
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
        var images = {
            localId: [],
            serverId: []
        };

        // 5.3 上传图片
        $(".uploadImage").click(function(){
            var that =$(this);
            images.localId = [];
            wx.chooseImage({
                success: function (res) {
                    images.localId = res.localIds;
                    if (images.localId.length == 0) {
                        alert('请先使用 chooseImage 接口选择图片');
                        return;
                    }
                    if(images.localId.length > 1) {
                        alert('目前仅支持单张图片上传,请重新上传');
                        images.localId = [];
                        return;
                    }
                    var i = 0, length = images.localId.length;
                    images.serverId = [];
                    function upload() {
                        wx.uploadImage({
                            localId: images.localId[i],
                            success: function (res) {
                                i++;
                                that.siblings('img.preview').attr('src',images.localId[0]);
                                // alert('已上传：' + i + '/' + length);
                                images.serverId.push(res.serverId);
                                that.siblings('input[type=hidden]').val(images.serverId[0]);
                                // alert( that.siblings('input[type=hidden]').val());
                                if (i < length) {
                                    upload();
                                }
                            },
                            fail: function (res) {
                                alert(JSON.stringify(res));
                            }
                        });
                    }
                    upload();
                }
            });
        });
        $("#submit").click(function(){
            $.ajax({
                type: 'post',
                url: $("form").attr('action')  ,
                data : $("form").serialize(),
                dataType: 'json',
                success : function(data){
                    if(data.status){
                        alert(data.info);
                        window.location.href = data.url;
                    }else{
                    }


                }
            });
            return false;
        })
    });

    wx.error(function(res){
        // config信息验证失败会执行error函数，如签名过期导致验证失败，
        // 具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，
        // 对于SPA可以在这里更新签名。
        //console.log(res);
        alert("验证失败，请重试！");
        wx.closeWindow();
    });



}

//拍照或从手机相册中选图接口
function wxChooseImage() {

    wx.chooseImage({
        success: function(res) {
            images.localId = res.localIds;
            alert('已选择 ' + res.localIds.length + ' 张图片');

            if (images.localId.length == 0) {
                alert('请先使用 chooseImage 接口选择图片');
                return;
            }
            var i = 0, length = images.localId.length;
            images.serverId = [];
            function upload() {
                //图片上传
                wx.uploadImage({
                    localId: images.localId[i],
                    success: function(res) {
                        i++;
                        images.serverId.push(res.serverId);
                        //图片上传完成之后，进行图片的下载，图片上传完成之后会返回一个在腾讯服务器的存放的图片的ID--->serverId
                        wx.downloadImage({
                            serverId: res.serverId, // 需要下载的图片的服务器端ID，由uploadImage接口获得
                            isShowProgressTips: 1, // 默认为1，显示进度提示
                            success: function (res) {
                                var localId = res.localId; // 返回图片下载后的本地ID

                                //通过下载的本地的ID获取的图片的base64数据，通过对数据的转换进行图片的保存
                                wx.getLocalImgData({
                                    localId: localId, // 图片的localID
                                    success: function (res) {
                                        var localData = res.localData; // localData是图片的base64数据，可以用img标签显示

                                        //通过ajax来将base64数据转换成图片保存在本地
                                        $.ajax({
                                            url: "./comment",
                                            type: "post",
                                            async: "false",
                                            dataType: "html",
                                            data: {
                                                localData: localData,
                                            },
                                            success: function (data) {
                                                var  mydata = JSON.parse(data);
                                                if(mydata.code == '0001'){
                                                    alert('已上传：' + i + '/' + length);
                                                }else{
                                                    alert('第：' + i + '/' + length+'上传失败');
                                                }
                                            },
                                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                                alert(errorThrown);
                                            },
                                        });
                                        $("#pic").append("<img src='"+localData+"'>");
                                    }
                                });
                            }
                        });
                        if (i < length) {
                            upload();
                        }
                    },
                    fail: function(res) {
                        alert(JSON.stringify(res));
                    }
                });
            }
            upload();
        }
    });
}