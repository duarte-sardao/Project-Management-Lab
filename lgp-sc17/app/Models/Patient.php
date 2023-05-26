<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Patient extends Appointable
{
    use HasFactory;

    protected $table = 'patients';

    protected $fillable = [
        'user_id',
        'healthcare_number',
        'questionnaire',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function hospital(): BelongsTo {
        return $this->belongsTo(Hospital::class);
    }
}
