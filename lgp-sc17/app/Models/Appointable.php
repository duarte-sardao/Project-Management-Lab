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

    public function getDate() {
        if($this->date == null)
            return '';
        return date_format($this->date, 'd-m-Y');
    }

    public function getTime() {
        if($this->time == null)
            return '';
        return date_format($this->time, 'h\hi');
    }
}

