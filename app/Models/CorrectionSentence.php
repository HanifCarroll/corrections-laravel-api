<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class CorrectionSentence extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'correction_id',
        'post_sentence_id',
        'corrected_text',
        'explanation',
    ];

    public function correction()
    {
        return $this->belongsTo(Correction::class);
    }

    public function postSentence()
    {
        return $this->belongsTo(PostSentence::class);
    }

}
