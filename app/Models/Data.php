<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'contact_no',
        'class_branch',
        'parent_name',
        'parent_contact_no',
        'school_college_name',
        'enquiry',
        'options',
        'description'
    ];

}
