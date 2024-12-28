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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('emp_id');
            $table->string('slug');
            $table->string('designation')->nullable();
            $table->double('salary', 12, 2)->nullable();
            $table->double('commission', 12, 2)->nullable();
            $table->string('mobile_number')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('gender')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('religion')->nullable();
            $table->date('appointment_date')->nullable();
            $table->date('joining_date')->nullable();
            $table->string('address')->nullable();
            $table->string('status')->nullable();
            $table->string('image')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('admins')->onDelete('cascade')->onUpdate('no action');
            $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('cascade')->onUpdate('no action');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
