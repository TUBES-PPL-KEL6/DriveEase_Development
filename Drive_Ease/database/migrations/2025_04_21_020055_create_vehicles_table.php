<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('vehicles', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('location');
        $table->enum('category', ['SUV', 'MPV', 'Sedan', 'Hatchback']);
        $table->text('description')->nullable();
        $table->integer('price_per_day');
        $table->boolean('available')->default(true);
        $table->string('image')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
