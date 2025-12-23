<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'content',
        'category_id',
        'user_id',
        'status',
        'is_guest',
        'guest_name',
        'guest_email',
        'guest_whatsapp',
        'views',
    ];

    public function visits()
    {
        return $this->morphMany(Visit::class, 'visitable');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'published');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
