<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'blog_id',
        'entry',
        'created_at',
        'updated_at',
    ];

    public $table = 'detail_blog';
}
