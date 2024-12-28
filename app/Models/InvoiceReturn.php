<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceReturn extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    /**
     * Get the invoice return products.
     */
    // public function invoiceReturnProducts()
    // {
    //     return $this->hasMany(InvoiceReturnProduct::class, 'return_id')->orderBy('product_id');
    // }

    /**
     * Get the transaction for this return.
     */
    public function returnTransaction()
    {
        return $this->belongsTo(AccountTransaction::class, 'transaction_id');
    }

    /**
     * Get the user who had created this return.
     */
    public function user()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
