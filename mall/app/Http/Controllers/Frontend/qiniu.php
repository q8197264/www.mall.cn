<?php
/**
 * test qinu.
 * User: sai
 * Date: 2018-12-25
 * Time: 11:16
 */
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    /*
     *  上传文件
     * 因为我们存储在数据库的七牛云文件信息是“key”值，
     * 所以在模版中显示七牛云文件时，需要用配置信息domain的值拼接模版获取到文件
     * key值，组装文件完整访问路径：
     */
    public function uploadFile(Request $request)
    {
        // 判断文件是否上传以及获取的文件是否是个有效的实例对象
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            return qiniuUpload($request->file('image'));
        }

        return "请上传文件！";
    }

    /*
     *  删除文件
     */
    public function deleteFile(Request $request)
    {
        $data = $request->validate([
            'key' => 'required'
        ]);

        qiniuDelete($data['key']);
    }

    /*
     * 下载文件
     */
    public function downloadFile(Request $request)
    {
        $data = $request->validate([
            'key' => 'required'
        ]);

        return qiniuDownload($data['key']);
    }

    /*
     *  获取文件列表
     */
    public function listFile()
    {
        return qiniuList();
    }
}
/**
// 获取原图
    <img src="{{ Config::get('filesystems.disks.qiniu.domain'). '/'. $info->image }}" width="100">


//    获取大小压缩的图片
//   加参数：?imageView/1/w/图片宽度/h/图片高度 ，可以只传宽度或者高度数据

<img src="{{ Config::get('filesystems.disks.qiniu.domain'). '/'. $info->image }}?imageView/1/w/200/h/100">

//   获取质量压缩的图片
//   format-新图片格式(只有jpg格式图片才能压缩)
//  quality-新图片质量
//   加参数：?imageMogr2/format/jpg/quality/质量大小

    <img src="{{ Config::get('filesystems.disks.qiniu.domain'). '/'. $info->image }}?imageMogr2/format/jpg/quality/40">
**/