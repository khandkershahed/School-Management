<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('no action');
            $table->foreignId('tax_id')->nullable()->constrained('vat_rates')->onDelete('cascade')->onUpdate('no action');
            $table->foreignId('created_by')->nullable()->constrained('admins')->onDelete('no action')->onUpdate('no action');
            $table->foreignId('updated_by')->nullable()->constrained('admins')->onDelete('no action')->onUpdate('no action');

            $table->string('invoice_no');
            $table->string('slug');
            $table->string('reference')->nullable();
            $table->double('transport', 12, 2)->nullable();
            $table->boolean('discount_type')->nullable()->comment('0 means fixed and 1 means percentage');
            $table->double('discount', 12, 2)->nullable();
            $table->double('sub_total', 12, 2)->nullable();
            $table->string('po_reference')->nullable();
            $table->string('payment_terms')->nullable();
            $table->string('delivery_place')->nullable();
            $table->date('invoice_date')->nullable();
            $table->string('note')->nullable();
            $table->boolean('status')->nullable()->default(1);
            $table->boolean('is_paid')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
