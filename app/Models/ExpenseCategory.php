<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    use HasFactory,HasSlug;
    protected $slugSourceColumn = 'name';
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    public function expenseSubCategory()
    {
        return $this->hasMany(ExpenseSubCategory::class, 'cat_id');
    }

    /**
     * Get all of the expneses for the category.
     */
    public function catAllExpenses()
    {
        return $this->hasManyThrough(Expense::class, ExpenseSubCategory::class, 'cat_id', 'sub_cat_id');
    }
}
