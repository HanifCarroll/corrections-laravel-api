<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\PostSentence;

class Post extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'title',
        'text',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sentences()
    {
        return $this->hasMany(PostSentence::class);
    }

    public function corrections()
    {
        return $this->hasMany(Correction::class);
    }
    
}
