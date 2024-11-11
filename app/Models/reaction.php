<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    use HasFactory;

    protected $fillable = ['blog_id', 'like', 'happy', 'sad', 'motivating'];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
