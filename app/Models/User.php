<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\HasSlug;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasSlug;
    protected $slugSourceColumn = 'name';
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

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
        'password' => 'hashed',
    ];
    public function isOld()
    {
        return $this->student_type === 'old';
    }

    // Check if student is new
    public function isNew()
    {
        return $this->student_type === 'new';
    }
    public function medium()
    {
        return $this->belongsTo(EducationMedium::class, 'medium_id');
    }
    public function invoices()
    {
        return $this->hasMany(StudentInvoice::class, 'student_id');
    }
    public function waivers()
    {
        return $this->hasMany(StudentFeeWaiver::class, 'student_id');
    }
    public function paidFees()
    {
        return $this->hasMany(StudentFee::class, 'student_id');
    }
    public function studentFees()
    {
        return $this->hasMany(StudentFee::class, 'student_id');
    }
}
