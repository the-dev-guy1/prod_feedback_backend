<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments'; // Specify the table name

    protected $fillable = [
        'content',
        'user_id',
        'feedback_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function feedback()
    {
        return $this->belongsTo(Feedback::class);
    }

    public function mentions()
    {
        return $this->belongsToMany(User::class, 'comment_mentions', 'comment_id', 'user_id');
    }
}
