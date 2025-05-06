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
    Schema::table('vehicles', function (Blueprint $table) {
        $table->foreignId('rental_id')->constrained('users')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('vehicles', function (Blueprint $table) {
        $table->dropColumn('rental_id');
    });
}

};
