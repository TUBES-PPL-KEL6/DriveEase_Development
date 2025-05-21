<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rental_id'); // relasi ke user rental
            $table->string('name');
            $table->string('phone');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('rental_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
