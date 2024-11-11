<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Comment;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'image',
        'tag',
        'name',
        'status',
        'approved_at',
        'description',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($blog) {
            $blog->slug = Str::slug($blog->title); // Generate slug from title
        });
        static::creating(function ($blog) {
            if (auth()->check()) {
                $blog->user_id = auth()->id(); // Assign the currently authenticated user's ID
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function reactions()
    {
        return $this->hasOne(Reaction::class);
    }

}
