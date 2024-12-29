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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medium_id')->nullable()->constrained('education_media')->onDelete('cascade')->onUpdate('no action');
            $table->string('student_id')->unique()->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('image')->nullable();
            $table->unsignedInteger('roll')->nullable();
            $table->string('class')->nullable();
            $table->string('section')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('guardian_contact')->nullable();
            $table->text('address')->nullable();
            $table->string('status')->nullable();
            $table->rememberToken();
            $table->timestamps();
            // $table->unsignedBigInteger('medium_id')->nullable();
            // $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            // $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            // $table->foreign('medium_id')->references('id')->on('mediums')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
