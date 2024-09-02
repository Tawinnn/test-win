<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'status'];

    public function images()
    {
        return $this->hasMany(BlogImage::class, 'blogs_id');
    }
}

class BlogImage extends Model
{
    use HasFactory;

    protected $fillable = ['blogs_id', 'image', 'status'];
}
