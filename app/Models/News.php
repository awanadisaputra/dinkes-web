<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'content',
        'user_id',
        'status',
        'views',
    ];

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function visits()
    {
        return $this->morphMany(Visit::class, 'visitable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
