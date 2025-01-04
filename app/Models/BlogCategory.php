<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;
     // Specify the table name if different from 'blogs'
     protected $table = 'blog_categories';

     // Allow mass assignment for these fields
     protected $fillable = ['id','name', 'slug'];
}
