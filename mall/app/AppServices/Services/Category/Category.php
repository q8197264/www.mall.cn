<?php
namespace App\AppServices\Services\Category;

/**
 * category show.
 * User: sai
 * Date: 2018-12-11
 * Time: 16:44
 */
class Category extends AbstractCategory
{
    public function initialize(){}

    public function show()
    {
        return static::getCategoryRepository()->show();
    }
}