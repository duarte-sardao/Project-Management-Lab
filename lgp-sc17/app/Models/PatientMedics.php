<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientMedics extends Model
{
    use HasFactory;

    protected $table = 'patient_medics';

    protected $fillable = [
        'id',
        'patient_id',
        'medic_id'
    ];
}
