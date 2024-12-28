<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory,HasSlug;
    protected $slugSourceColumn = 'reason';
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function expSubCategory()
    {
        return $this->belongsTo(ExpenseSubCategory::class, 'sub_cat_id');
    }
    public function expCategory()
    {
        return $this->belongsTo(ExpenseCategory::class, 'cat_id');
    }

    /**
     * Get the tansaction for this expense.
     **/
    public function expTransaction()
    {
        return $this->belongsTo(AccountTransaction::class, 'transaction_id');
    }

    /**
     * Get the user who had created this expense.
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
