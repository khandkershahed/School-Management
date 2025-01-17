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
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('package_id')->nullable()->constrained('fee_packages')->onDelete('set null')->onUpdate('no action');
            $table->string('name');
            $table->string('slug');
            $table->json('class')->nullable();
            $table->text('description')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('medium')->nullable();
            $table->json('fee_package')->nullable();
            $table->enum('fee_type', ['monthly', 'yearly', 'recurring'])->default('yearly')->nullable();  // Monthly or Yearly
            $table->string('status');
            $table->timestamps();
        });
        // $table->foreignId('medium_id')->nullable()->constrained('education_media')->onDelete('set null')->onUpdate('no action');
        // $table->foreignId('class_id')->nullable()->constrained('student_classes')->onDelete('set null')->onUpdate('no action');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fees');
    }
};
