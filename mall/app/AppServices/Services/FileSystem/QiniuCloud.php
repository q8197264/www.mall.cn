<?php
namespace Services\FileSystem;

use mysql_xdevapi\Exception;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;

/**
 * Qiniu.
 *
 * User: sai
 * Date: 2018-12-26
 * Time: 03:28
 *
$disk = \Storage::disk('qiniu');
$disk->exists('file.jpg');                      //文件是否存在
$disk->get('file.jpg');                         //获取文件内容
$disk->put('file.jpg',$contents);               //上传文件，$contents 二进制文件流
$disk->prepend('file.log', 'Prepended Text');   //附加内容到文件开头
$disk->append('file.log', 'Appended Text');     //附加内容到文件结尾
$disk->delete('file.jpg');                      //删除文件
$disk->delete(['file1.jpg', 'file2.jpg']);
$disk->copy('old/file1.jpg', 'new/file1.jpg');  //复制文件到新的路径
$disk->move('old/file1.jpg', 'new/file1.jpg');  //移动文件到新的路径
$size = $disk->size('file1.jpg');               //取得文件大小
$time = $disk->lastModified('file1.jpg');       //取得最近修改时间 (UNIX)
$files = $disk->files($directory);              //取得目录下所有文件
$files = $disk->allFiles($directory);               //取得目录下所有文件，包括子目录

这三个对七牛来说无意义
$directories = $disk->directories($directory);      //这个也没实现。。。
$directories = $disk->allDirectories($directory);   //这个也没实现。。。
$disk->makeDirectory($directory);               //这个其实没有任何作用

$disk->deleteDirectory($directory);             //删除目录，包括目录下所有子文件子目录

$disk->getDriver()->uploadToken();            //获取上传Token ,可选'file.jpg'
$disk->getDriver()->putFile('file.jpg', 'local/filepath');            //上传本地大文件
$disk->getDriver()->downloadUrl('file.jpg');            //获取下载地址
$disk->getDriver()->privateDownloadUrl('file.jpg');     //获取私有bucket下载地址
$disk->getDriver()->imageInfo('file.jpg');              //获取图片信息
$disk->getDriver()->imageExif('file.jpg');              //获取图片EXIF信息
$disk->getDriver()->imagePreviewUrl('file.jpg','imageView2/0/w/100/h/200');              //获取图片预览URL
$disk->getDriver()->persistentFop('file.flv','avthumb/m3u8/segtime/40/vcodec/libx264/s/320x240');   //执行持久化数据处理
$disk->getDriver()->persistentStatus($persistent_fop_id);          //查看持久化数据处理的状态。
$disk->getDriver()->fetch($url, $key);          //从指定URL抓取资源，并将该资源存储到指定空间中。
 */
class QiniuCloud extends AbstractFileSystem
{
    protected $auth;
    protected $config;

    public function initailize()
    {
        $this->auth = $this->qiniuConfig();
    }

    /*
     *  构建鉴权对象
     */
    protected function qiniuConfig()
    {
        // 获取七牛云配置信息
        $this->config = $this->app->config->get('filesystems.disks.qiniu');

        // 构建鉴权对象
        $auth = new Auth($this->config['access_key'], $this->config['secret_key']);

        return $auth;
    }

    /*
     *  上传文件
     *  参数$file：上传文件的信息，如 $request->file('image')
     *
     * return array
       [
        "fsize"   => 86
        "hash"    =>"FqQm4JxubzE_peA8c1bKRdkJfvwc"
        "key"     =>"15458200002022632171.png"
        "mimeType"=>"text/plain"
       ]
     */
    public function qiniuUpload($file)
    {
        // 生成上传 Token
        $token = $this->auth->uploadToken($this->config['bucket']);

        //获取文件的绝对路径，但是获取到的在本地不能打开
        $filePath = $file->getRealPath();

        //获取文件的扩展名
        $ext = $file->getClientOriginalExtension();

        // 新文件名
        $key = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
        // 初始化 UploadManager 对象并进行文件的上传。
        $uploadMgr = new UploadManager();

        // 调用 UploadManager 的 putFile 方法进行文件的上传。
        $uploadMgr->putFile($token, $key, $filePath);

        // 返回上传到云纯属的关键字信息

        return $key;
    }

    public function fetchFromUrl(string $url)
    {
        if (empty($url)) {
            throw new Exception('url is null');
        }

        // $key = null 不指定key时，以文件内容的hash作为文件名
        $key = time().rand().'.png';

        $bucketManager = new BucketManager($this->auth);

        // 指定抓取的文件保存名称
        list($ret, $err) = $bucketManager->fetch($url, $this->config['bucket'], $key);

        if (!empty($err)) {
            throw new Exception($err);
        }

        return $ret;
    }

    /*
     *  删除文件
     *  参数：$key —— 在七牛云上保存的文件关键字，如：2018-11-16-12-14-03-5bee440ba7e09.png
     */
    public function qiniuDelete($key)
    {
        // 构建 UploadManager 对象
        $bucketMgr = new BucketManager($this->auth);
        // 删除
        $err = $bucketMgr->delete($this->config['bucket'], $key);

        if ($err !== null) {
            \Log::alert('deleteImgError', $err);
        }
    }

    /*
     *  获取七牛云上的文件列表
     *  注意：这里默认是获取前1000个文件，如果需要更多操作，可以自己查Qiniu\Storage\BucketManager中的listFiles方法进行修改。
     */
    public function qiniuList()
    {
        // 构建 UploadManager 对象
        $bucketMgr = new BucketManager($this->auth);
        // 获取列表信息
        list($ret, $err) = $bucketMgr->listFiles($this->config['bucket']);

        // 判断结果
        if ($err !== null) {
            return ["err" => 1, "msg" => $err, "data" => ""];
        } else {
            foreach ($ret as &$row) {
                $row[0]['key'] = $this->config['domain'].'/'.$row[0]['key'];
            }

            //返回文件列表完整信息
            return $ret;
        }
    }

    /*
     *  下载指定key值的七牛云文件
     *  参数$key：指定文件存储在七牛云上的关键字，如：2018-11-16-12-14-03-5bee440ba7e09.png
     */
    public function qiniuDownload($key)
    {
        // 获取指定文件的大小
        $fileSize = $this->qiniuStat($key)[0]['fsize'];
        // 获取指定key的文件完整路径

        $filePath = $this->config['domain'] . "/" . $key;
        // 打开浏览器的缓存区
        ob_start();
        // 构建下载header信息，开始下载
        header("Content-type: application/octet-stream");
        header("Accept-Ranges: bytes");
        header("Content-Disposition:attachment;filename={$key}");
        header("Accept-Length:{$fileSize}");
        readfile($filePath);
    }


    /*
     *  获取指定文件的元信息，包括文件大小等
     *  参数$key：指定文件存储在七牛云上的关键字，如：2018-11-16-12-14-03-5bee440ba7e09.png
     */
    protected function qiniuStat($key)
    {
        // 构建 UploadManager 对象
        $bucketMgr = new BucketManager($this->auth);
        // 获取列表信息
        return $bucketMgr->stat($this->config['bucket'], $key);
    }



}