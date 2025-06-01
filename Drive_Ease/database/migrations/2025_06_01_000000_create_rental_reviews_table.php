<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rental_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->tinyInteger('rating')->unsigned()->comment('1 to 5');
            $table->text('comment')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
            
            // Ensure one review per booking
            $table->unique('booking_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rental_reviews');
    }
}; 