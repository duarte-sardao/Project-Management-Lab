<?php

use App\Models\Medic;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create guest
        User::create(
            array(
                'username' => 'guest',
                'email' => 'guest@vivercomdm1.pt',
                'name' => 'Guest',
                'password' => Hash::make('guest!password')
            )
        );

        // Create patient
        $patient = User::create(
            array(
                'username' => 'patient',
                'email' => 'patient@vivercomdm1.pt',
                'name' => 'Patient',
                'password' => Hash::make('patient!password')
            )
        );

        Patient::create(
            array(
                'user_id' => $patient->id,
                'healthcare_number' => 123456789,
                'questionnaire' => ''
            )
        );

        // Create doctor
        $doctor = User::create(
            array(
                'username' => 'doctor',
                'email' => 'doctor@vivercomdm1.pt',
                'name' => 'Doctor',
                'password' => Hash::make('doctor!password')
            )
        );

        Medic::create(
            array(
                'user_id' => $doctor->id,
                'license_number' => 123456789,
            )
        );

        // Create admin
        User::create(
            array(
                'username' => 'admin',
                'email' => 'admin@vivercomdm1.pt',
                'name' => 'Admin',
                'password' => Hash::make('admin!password'),
                'is_admin' => true
            )
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
