<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Comment;
use App\Notifications\NewBlogCreatedNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\Admin; 

class Blog extends Model
{
    use HasFactory, SoftDeletes;
    protected $casts = [
        'tag' => 'array',
    ];
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
            $blog->slug = Str::slug($blog->title); 
        });
        static::creating(function ($blog) {
            if (auth()->check()) {
                $blog->user_id = auth()->id(); 
            }
        });
        static::created(function ($blog) {
            $admins = Admin::all();
            Notification::send($admins, new NewBlogCreatedNotification($blog));
        });
    }
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
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
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'blog_tag');
    }

}
