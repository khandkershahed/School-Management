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
        Schema::create('student_fee_waivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->nullable()->constrained('users')->onDelete('set null')->onUpdate('no action');
            $table->foreignId('fee_id')->nullable()->constrained('fees')->onDelete('set null')->onUpdate('no action');
            $table->decimal('amount', 10, 2)->nullable();
            $table->decimal('percentage', 10, 2)->nullable();
            $table->decimal('package_amount', 10, 2)->nullable();
            $table->decimal('package_percentage', 10, 2)->nullable();
            $table->string('status')->nullable();
            $table->foreignId('added_by')->nullable()->constrained('admins')->onDelete('set null')->onUpdate('no action');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_fee_waivers');
    }
};
