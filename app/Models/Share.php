<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Post;
class Share extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'post_id'];

    // Relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Post model
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
