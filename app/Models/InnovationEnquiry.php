<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InnovationEnquiry extends Model
{
    use HasFactory;
    use HasFactory;
    public const VIEW = 'admin-views.innovationenquiry.list';
    public const LIST = [
        'URI' => '/list', 
    ];
    protected $table = 'innovation_enquiry';
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
