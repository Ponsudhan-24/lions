<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerEnquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',  // Changed from 'name' to 'first_name'
        'last_name',   // Added 'last_name'
        'email',
        'phone',
        'position',
        'experience',
        'motivation',
        'resume',
        'source',
    ];
}
