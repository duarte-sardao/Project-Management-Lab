<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalStaff extends Model
{
    use HasFactory;

    protected $table = 'medical_staff';

    protected $fillable = [
        'user_id',
        'license_number',
    ];
}
