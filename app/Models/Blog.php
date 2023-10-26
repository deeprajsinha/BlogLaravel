<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'body',
        'status',
        'user_id',
    ];

    /**
     * Fetch user of this blog
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
