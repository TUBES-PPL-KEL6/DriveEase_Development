<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reviewer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('reviewed_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('rent_id')->constrained('rents')->onDelete('cascade');
            $table->tinyInteger('rating')->unsigned()->comment('1 to 5');
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->unique(['reviewer_id', 'reviewed_id', 'rent_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_reviews');
    }
}; 