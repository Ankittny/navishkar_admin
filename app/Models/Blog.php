<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    // Specify the table name if different from 'blogs'
    protected $table = 'blogs';

    // Allow mass assignment for these fields
    protected $fillable = ['id','cat_id', 'title','description', 'image','slug','meta_title','meta_discription','keywords'];
}
