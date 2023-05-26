<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patients';

    protected $fillable = [
        'user_id',
        'healthcare_number',
        'questionnaire',
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
