<?php
namespace App\AppServices\Services\Comment;

use Illuminate\Container\Container as App;

/**
 * Comment service.
 *
 * User: sai
 * Date: 2018-12-24
 * Time: 00:02
 */
abstract class AbstractComment
{
    protected $app;
    protected static $commentRepository;

    public function __construct(App $app)
    {
        if (empty($this->getCommentRepository())) {
            static::$commentRepository = $app->make('App\AppServices\Repositories\Comment\CommentRepository');
        }
        $this->app = $app;
    }

    public function getCommentRepository()
    {
        return static::$commentRepository;
    }

    abstract protected function initialize();
}