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

    /**
     * fetch file from other url
     *
     * @param array $media_ids
     *
     * @return array
     */
    public function fetchFileFromUrl(array $media_ids):array
    {
        //从微信服务器下载
        foreach ($media_ids as $media_id) {
            try{
                $urlList = (new JSSDK())->getWechatImageUrl($media_id);

                //fetch to qiniu from wechat
                $info = $this->qiniuCloud->fetchFromUrl($urlList);

                $res[] = $info['key'];
            }catch(\Exception $e){
                $res['code'] = 1;
                $res['msg']  = $e->getMessage();
            }
        }

        return $res;
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