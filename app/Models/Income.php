<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Income extends Model
{
    use HasFactory,HasSlug;
    protected $slugSourceColumn = 'reason';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    public function incomeSubCategory()
    {
        return $this->belongsTo(IncomeSubCategory::class, 'sub_cat_id');
    }
    public function incomeCategory()
    {
        return $this->belongsTo(IncomeCategory::class, 'cat_id');
    }

    /**
     * Get the tansaction for this expense.
     **/
    public function incomeTransaction()
    {
        return $this->belongsTo(AccountTransaction::class, 'transaction_id');
    }

    /**
     * Get the user who had created this incomeense.
     **/
    public function addUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updateUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
