<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'username',
        'email',
        'phone_number',
        'password',
        'profile_img_url',
        'is_admin',
        'banned'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function follow() {
        return $this->belongsToMany(Topic::class, 'follows');
    }

    public function posts() {
        return $this->hasManyThrough(ForumPost::class, Post::class, 'author');
    }

    public function status(): string {
        if ($this->isPatient()) {
            return 'Patient';
        } elseif ($this->isMedic()) {
            return 'Medic';
        }
        return 'Guest';
    }

    public function isBanned(): bool {
        return $this->banned;
    }

    public function isGuest(): bool {
        return !($this->isPatient() || $this->isMedic());
    }

    public function isPatient(): bool {
        return Patient::where('user_id','=',$this->id)->exists();
    }

    public function isMedic(): bool {
        return Medic::where('user_id','=',$this->id)->exists();
    }

    public function setBan($b_bool) {
        $this->banned = $b_bool;
        $this->save();
    }

    public function messages() {
        return $this->hasMany(Message::class);
    }
}
