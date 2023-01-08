<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\detail_blog;
use App\Models\comment;

class blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'judul',
        'short_content',
        'jumlah_comment',
        'status',
        'created_at',
        'updated_at',
    ];

    public $table = 'blog';

    public function detail()
    {
        return $this->hasOne(detail_blog::class, 'blog_id');
    }
    public function comment()
    {
        return $this->hasMany(comment::class, 'id_detail_blog');
    }
}
