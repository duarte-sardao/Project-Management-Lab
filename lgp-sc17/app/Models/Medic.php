<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Medic extends Appointable
{
    use HasFactory;

    protected $table = 'medics';

    protected $fillable = [
        'user_id',
        'license_number',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function hospital(): BelongsTo {
        return $this->belongsTo(Hospital::class);
    }
}
