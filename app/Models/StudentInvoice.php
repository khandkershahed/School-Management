<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentInvoice extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $casts = [
        'generated_at' => 'datetime',
    ];

    protected $guarded = [];
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
    public function fee()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
