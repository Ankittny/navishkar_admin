<?php

namespace App\Enums\ViewPaths\Admin;

enum InnovationEnquiry
{
    const LIST = [
        URI => 'list',
        VIEW => 'admin-views.innovationenquiry.list'
    ];
    const ADD = [
        URI => 'add-new',
        VIEW => 'admin-views.innovationenquiry.add-new'
    ];

    const UPDATE = [
        URI => 'update',
        VIEW => 'admin-views.innovationenquiry.edit'
    ];

    const DELETE = [
        URI => 'delete',
        VIEW => ''
    ];

   
}
