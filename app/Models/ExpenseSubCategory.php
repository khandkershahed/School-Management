<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExpenseSubCategory extends Model
{
    use HasFactory,HasSlug;
    protected $slugSourceColumn = 'name';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class, 'cat_id');
    }

    /**
     * Get all expenses.
     */
    public function allExpenses()
    {
        return $this->hasMany(Expense::class, 'sub_cat_id');
    }
}
