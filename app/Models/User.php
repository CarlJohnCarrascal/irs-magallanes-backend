<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role',
        'firstname',
        'lastname',
        'middlename',
        'phone',
        'barangay',
        'address',
        'email',
        'password',
        'status',
        'imagesrc',
        'report_made',
        'fullname',
    ];

    public function getReportMadeAttribute() {
        return Incident::all()->where('userid', '=', $this->id)->count();
    }
    public function getFullnameAttribute() {
        return $this->firstname . " " . $this->lastname;
    }

    protected $appends = [
        'report_made',
        'fullname',
    ];
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
