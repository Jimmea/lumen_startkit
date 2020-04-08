<?php
/**
 * Created by PhpStorm.
 * User: Hungokata
 * Date: 8/4/19
 * Time: 17:30
 */

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends BaseModel
{
    use SoftDeletes;
    protected $casts = ['extra' => 'array'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function recentComments($limit = 5)
    {
        /*
         * Hiển thị các bình luận mới
         *
         * posts?include=comments
         */
        return $this->comments()->limit($limit);
    }
}