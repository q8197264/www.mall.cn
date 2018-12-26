<?php
namespace App\AppServices\Services\Comment;

/**
 * Comment service
 *
 * User: sai
 * Date: 2018-12-23
 * Time: 23:59
 */
class Comment extends AbstractComment
{
    protected $fileSystemService;
    protected $userRepository;

    protected function initialize()
    {
        $this->fileSystemService = $this->app
            ->make('Services\FileSystemService');
        $this->userRepository = $this->app
            ->make('App\AppServices\Repositories\User\UserRepository');
    }

    public function getGoodsWithCommented(int $order_id)
    {
        return $this->getCommentRepository()->queryGoodsWithCommented($order_id);
    }

    /**
     * get goods with wait comment
     *
     * @param int $order_id
     *
     * @return mixed
     */
    public function getGoodsWithWaitComment(int $order_id, int $sku_id):array
    {
        return $this->getCommentRepository()->queryGoodsWithWaitComment($order_id, $sku_id);
    }

    public function save(array $parameters )
    {
        $user = $this->userRepository->queryUserById($parameters['user_id']);
        $parameters['nickname'] = $user['nickname'];
dd($parameters);
        //is file
        if (!empty($parameters['media_ids'])) {
            // save 七牛 判断文件是否上传以及获取的文件是否是个有效的实例对象
            $parameters['image_list']= $this->fileSystemService->fetchFileFromUrl($parameters['media_ids']);//$request->file('image')

            //事务插入
            // $order_id, $sku_id, $comment_content
            $id = $this->getCommentRepository()->addCommentAndImage($parameters);
        } else {
            //insert
            $id = $this->getCommentRepository()->addOnlyComment($parameters);
        }

        return $id;
    }
}