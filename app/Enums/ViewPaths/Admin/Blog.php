<?php

namespace App\Enums\ViewPaths\Admin;

enum Blog
{
    const LIST = [
        URI => 'cat_list',
        VIEW => 'admin-views.blog.list'
    ];

    const LISTBLOG = [
        URI => 'list',
        VIEW => 'admin-views.blog.blog_list_index'
    ];

    const AAD = [
        URI => 'add-new',
        VIEW => ''
    ];

    const AAD1 = [
        URI => 'blog-home-add',
        VIEW => ''
    ];

    const UPDATE = [
        URI => 'update',
        VIEW => 'admin-views.blog.edit'
    ];
    const UPDATEBLOG = [
        URI => 'update-blog',
        VIEW => 'admin-views.blog.edit_blog'
    ];
}
