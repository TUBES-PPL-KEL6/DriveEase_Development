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
        Schema::create('rents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users');
            $table->foreignId('car_id')->constrained('cars');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('total_price', 10, 2);
            // $table->foreignId('payment_id')->constrained('payments');
            // $table->foreignId('review_id')->constrained('reviews');
<<<<<<< HEAD
<<<<<<< HEAD
            $table->string('side_note')->nullable();
=======
>>>>>>> main
=======
            $table->string('side_note')->nullable(); // <- dipertahankan
>>>>>>> a12a50e6f22bd2accec52c882319b39038630ff6
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rents');
    }
};
