<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointable extends Model
{
    protected $fillable = [
        'date',
        'time'
    ];

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
        //verify if its in the past and nullify if so?
        return $nextAppointment;
    }
}

