<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    public function scopeActiveEntries($query)
    {
        return $query->where(['status' => 1, 'is_approved' => 1]);
    }

    public function scopeWithLocalize($query)
    {
        return $query->where(['language' => getLanguage()]);
    }

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

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    
}
