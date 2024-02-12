<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'news_tags');
    }

    public function Category()
    {
        return $this->belongsTo(Category::class);
    }

    public function Auther()
    {
        return $this->belongsTo(Admin::class);
    }
}
