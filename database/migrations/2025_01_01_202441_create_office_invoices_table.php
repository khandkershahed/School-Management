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
        Schema::create('office_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->nullable()->constrained('users')->onDelete('set null')->onUpdate('no action');
            $table->string('invoice_number')->unique();
            $table->string('month');
            $table->year('year');
            $table->decimal('total_amount', 10, 2);
            $table->timestamp('generated_at')->useCurrent();
            $table->string('invoice');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('office_invoices');
    }
};
