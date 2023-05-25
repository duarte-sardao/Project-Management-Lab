<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Musonza\Chat\Traits\Messageable;

class Medic extends Model
{
    use HasFactory, Messageable;

    protected $table = 'medics';

    protected $fillable = [
        'user_id',
        'license_number',
    ];

    public function hospital(): BelongsTo {
        return $this->belongsTo(Hospital::class);
    }

    public function team() {
        return $this->hasMany(Team::class);
    }
}
