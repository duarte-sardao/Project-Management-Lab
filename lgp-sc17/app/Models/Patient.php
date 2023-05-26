<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Musonza\Chat\Traits\Messageable;

class Patient extends Model
{
    use HasFactory, Messageable;

    protected $table = 'patients';

    protected $fillable = [
        'user_id',
        'healthcare_number',
        'questionnaire',
    ];

    public function hospital(): BelongsTo {
        return $this->belongsTo(Hospital::class);
    }
}
