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
        'hospital_id',
        'date',
        'time'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function hospital(): BelongsTo {
        return $this->belongsTo(Hospital::class);
    }

    public function setDate($date, $time) {
        $this->date = $date;
        $this->time = $time;
        $this->save();
    }

    public function nextAppointment() {
        $nextAppointment = [
            'time' => $this->time,
            'date' => $this->date
        ];
        return $nextAppointment;
    }
}
