<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BePartnerWithUs extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'oraganization_name',
        'location',
        'contact_number',
        'official_email',
        'querry_description',
    ];
}
