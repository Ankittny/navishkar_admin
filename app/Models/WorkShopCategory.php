<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkShopCategory extends Model
{
    use HasFactory;

    // Specify the table name if different from 'blogs'
    protected $table = 'work_shop_category';

    // Allow mass assignment for these fields
    protected $fillable = [
        'id',
        'name',
        'slug',
        'meta_title',
        'description',
        'keywords',
        'created_at',
        'updated_at'
    ];
    
}
