<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fee extends Model
{
    use HasFactory, HasSlug;
    protected $slugSourceColumn = 'name';
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    public function medium()
    {
        return $this->belongsTo(EducationMedium::class, 'medium_id');
    }

    public function studentFees()
    {
        return $this->hasMany(StudentFee::class);
    }

    /**
     * Get the months the student has paid for this fee.
     *
     * @param  int  $studentId
     * @return array
     */
    public function paidMonths(int $studentId)
    {
        // Fetch the student fees for this fee and the given student
        $studentFees = $this->studentFees()
            ->where('student_id', $studentId)
            ->whereNotNull('paid_at')  // Only consider paid fees
            ->get();

        $paidMonths = [];

        // Loop through the student fees and extract the months
        foreach ($studentFees as $studentFee) {
            $paidMonths[] = Carbon::parse($studentFee->paid_at)->month; // Get month number
        }

        return $paidMonths;
    }
}
