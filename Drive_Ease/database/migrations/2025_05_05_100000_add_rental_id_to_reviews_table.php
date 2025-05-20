<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->foreignId('rental_id')->nullable()->constrained('users')->onDelete('cascade')->after('vehicle_id');
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['rental_id']);
            $table->dropColumn('rental_id');
        });
    }
}; 