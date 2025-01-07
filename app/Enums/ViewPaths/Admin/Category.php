<?php

namespace App\Enums\ViewPaths\Admin;

enum Category
{
    const LIST = [
        URI => 'view',
        VIEW => 'admin-views.category.view'
    ];
    const WORKSHOPVIEW = [
        URI => 'work-shop',
        VIEW => 'admin-views.category.work-shop-category.view'
    ];
    const WORKSHOPUPDATE = [
        URI => 'update-work-shops/{id}',
        VIEW => 'admin-views.category.work-shop-category.category-edit'
    ];
    const WORKSHOPADD = [
        URI => 'add-work-shop',
        VIEW => ''
    ];

    const WORKSHOPUPDATEDATA = [
        URI => 'update-work-shop-data',
        VIEW => ''
    ];
    const WORKSHOPDELETE = [
        URI => 'delete-delete',
        VIEW => ''
    ];
    const ADD = [
        URI => 'add-new',
        VIEW => 'admin-views.brand.add-new'
    ];
    const UPDATE = [
        URI => 'update/{id}',
        VIEW => 'admin-views.category.category-edit'
    ];
    const DELETE = [
        URI => 'delete',
        VIEW => ''
    ];
    const STATUS = [
        URI => 'status',
        VIEW => ''
    ];
 	const ORGANICSTATUS = [
        URI => 'organicstatus',
        VIEW => ''
    ];
    const ORGANIC = [
        URI => 'organic',
        VIEW => ''
    ];
    const EXPORT = [
        URI => 'export',
        VIEW => ''
    ];

}
