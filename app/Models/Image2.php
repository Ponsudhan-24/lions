<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image2 extends Model
{
    use HasFactory;

    protected $fillable = ['id','image_path', 'website_link'];

}
