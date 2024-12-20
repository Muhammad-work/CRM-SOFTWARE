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
        Schema::create('customer_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name')->nullable();
            $table->longText('customer_number')->nullable();
            $table->foreignId('agent')->constrained('users')->onDelete('cascade');
            $table->string('date'); 
            $table->string('status')->default('pending');
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_numbers');
    }
};
