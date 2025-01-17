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
        Schema::create('fee_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');  // Name of the package (e.g., "Session Charge")
            $table->string('slug');  // Name of the package (e.g., "Session Charge")
            $table->decimal('total_amount', 10, 2)->nullable();  // The total amount of the package
            $table->decimal('waiver_percentage', 5, 2)->default(0)->nullable();  // The discount/waiver percentage
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_packages');
    }
};
