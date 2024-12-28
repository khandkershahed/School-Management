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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug')->unique();
            $table->string('reason')->nullable();
            $table->date('date')->nullable();
            $table->text('note')->nullable();
            $table->double('amount')->nullable();
            $table->string('status')->default('active')->nullable()->comment('inactive,active');
            $table->string('image')->nullable();
            $table->foreignId('cat_id')->nullable()->constrained('expense_categories')->onDelete('cascade')->onUpdate('no action');
            $table->foreignId('sub_cat_id')->nullable()->constrained('expense_sub_categories')->onDelete('cascade')->onUpdate('no action');
            $table->foreignId('transaction_id')->nullable()->constrained('account_transactions')->onDelete('cascade')->onUpdate('no action');
            $table->foreignId('created_by')->nullable()->constrained('admins')->onDelete('no action')->onUpdate('no action');
            $table->foreignId('updated_by')->nullable()->constrained('admins')->onDelete('no action')->onUpdate('no action');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
