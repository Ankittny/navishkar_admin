<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkShopProduct extends Model
{
    use HasFactory;

    // Specify the table name if different from 'blogs'
    protected $table = 'work_shop_product';

    // Allow mass assignment for these fields
    protected $fillable = [
        'id',
        'name',
        'slug',
        'cat_id',
        'image',
        'meta_title',
        'meta_description',
        'meta_title',
        'description',
        'keywords',  
        'created_at',
        'updated_at'
    ];
    
}
