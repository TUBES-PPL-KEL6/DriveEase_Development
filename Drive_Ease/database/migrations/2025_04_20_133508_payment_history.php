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
        Schema::create('payment_history', function (Blueprint $table) {
            $table->id(); // This creates an auto-incrementing primary key column named 'id'
            $table->string('username')->nullable(); // Assuming username is a string and can be nullable
            $table->string('car')->nullable();      // Assuming car is a string and can be nullable
            $table->decimal('price', 10, 2)->nullable(); // Assuming price is a decimal with 10 total digits and 2 decimal places, and can be nullable
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();


        });
    }


    public function down(): void
    {
        Schema::dropIfExists('payment_history');
    }
};