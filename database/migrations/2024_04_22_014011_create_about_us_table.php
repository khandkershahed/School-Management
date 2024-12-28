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
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            $table->string('title', 60);
            $table->string('slug', 80)->unique();
            $table->string('badge', 11);
            $table->string('short_description', 255);
            $table->string('image', 100)->nullable()->comment('Image Dimension: 697 x 465');
            $table->string('button_name', 11)->nullable();
            $table->string('button_link', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_us');
    }
};
