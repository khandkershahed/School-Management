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
        Schema::create('student_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->nullable()->constrained('users')->onDelete('set null')->onUpdate('no action');
            $table->foreignId('fee_id')->nullable()->constrained('fees')->onDelete('set null')->onUpdate('no action');
            $table->string('month');
            $table->year('year');
            $table->enum('status', ['Paid', 'Unpaid'])->default('Unpaid');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_fees');
    }
};
