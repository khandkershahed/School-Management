<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentFee extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    public function fee()
    {
        return $this->belongsTo(Fee::class, 'fee_id');
    }
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
