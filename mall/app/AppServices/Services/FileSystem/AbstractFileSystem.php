<?php
namespace Services\FileSystem;

use Illuminate\Container\Container as App;

/**
 * Created by PhpStorm.
 * User: sai
 * Date: 2018-12-26
 * Time: 04:24
 */
abstract class AbstractFileSystem
{
    protected $app;
    protected static $commentRepository;

    public function __construct(App $app)
    {
        if (empty($this->getCommentRepository())) {
            static::$commentRepository = $app
                ->make('App\AppServices\Repositories\Comment\CommentRepository');
        }
        $this->app = $app;
        $this->initailize();
    }

    public function getCommentRepository()
    {
        return static::$commentRepository;
    }

    abstract protected function initailize();

}