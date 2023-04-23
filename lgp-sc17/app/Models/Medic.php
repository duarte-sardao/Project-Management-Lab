<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Medic extends Model
{
    use HasFactory;

    protected $table = 'medics';

    protected $fillable = [
        'user_id',
        'license_number',
    ];

    public function hospital(): BelongsTo {
        return $this->belongsTo(Hospital::class);
    }
}
