<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyBlogView extends Model
{
    protected $table = 'daily_blog_views';
    public $timestamps = false;

    
    // Disable mass assignment protection
    protected $guarded = [];

    // Make the model read-only
    public function save(array $options = [])
    {
        return false;
    }
    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blog_id');
    }
}
