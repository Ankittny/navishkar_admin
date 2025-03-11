<?php

namespace App\Enums\ViewPaths\Admin;

enum Review
{
    const LIST = [
        URI => 'list',
        VIEW => 'admin-views.reviews.list'
    ];

    const ADD_REVIEW = [
        URI => 'add',
        VIEW => 'admin-views.reviews.add'
    ];



    const STATUS = [
        URI => 'status/{id}/{status}',
        VIEW => ''
    ];

    const SEARCH = [
        URI => 'customer-list-search',
        VIEW => ''
    ];

    const SEARCH_PRODUCT = [
        URI => 'search-product',
        VIEW => 'admin-views.partials._search-product'
    ];

    const REVIEW_REPLY = [
        URI => 'add-review-reply',
        VIEW => ''
    ];

    const REVIEW = [
        URI => 'review',
        VIEW => ''
    ];
    
    const EXPORT = [
        URI => 'export',
        VIEW => ''
    ];

    const DELETE = [
        URI => 'delete',
        VIEW => ''
    ];
   
}
