<?php
namespace Services;

use Libraries\Wechat\Jssdk\JSSDK;
use Services\FileSystem\QiniuCloud;

/**
 * Cloud Storage
 *
 * Created by PhpStorm.
 * User: sai
 * Date: 2018-12-25
 * Time: 23:52
 */
class FileSystemService
{
    protected $qiniuCloud;

    public function __construct(QiniuCloud $qiniuCloud)
    {
        $this->qiniuCloud = $qiniuCloud;
    }

    public function uploadFile(string $file, int $comment_id=0)
    {
//        $filepath = (new JSSDK())->downloadImage($file);
//        if (!empty($filepath)) {
            //insert db
            return $this->qiniuCloud->qiniuUpload($file);
//        }


//        return $id??0;
    }


    public function deleteFile(string $key)
    {
        $this->qiniuCloud->qiniuDelete($key);
    }

    public function downloadFile($key)
    {
        return $this->qiniuCloud->qiniuDownload($key);
    }

    public function listFile()
    {
        return $this->qiniuCloud->qiniuList();

    }

}