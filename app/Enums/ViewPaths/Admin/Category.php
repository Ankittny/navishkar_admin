<?php

namespace App\Enums\ViewPaths\Admin;

enum Category
{
    const LIST = [
        URI => 'view',
        VIEW => 'admin-views.category.view'
    ];

    const INGREDIENTS = [
        URI => 'ingredient-view',
        VIEW => 'admin-views.ingredient.view'
    ];
    
    const ADD = [
        URI => 'add-new',
        VIEW => 'admin-views.brand.add-new' 
    ];
    const UPDATE = [
        URI => 'update/{id}',
        VIEW => 'admin-views.category.category-edit' 
    ];

    const INGREDIENTUPDATE = [
        URI => 'update-ingredient/{id}',
        VIEW => 'admin-views.ingredient.ingredient-edit'
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
