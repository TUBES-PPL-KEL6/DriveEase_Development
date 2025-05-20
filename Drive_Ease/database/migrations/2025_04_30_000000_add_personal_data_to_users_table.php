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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('id_card')->nullable();
            $table->string('driver_license')->nullable();
            $table->string('company_name')->nullable();
            $table->text('company_address')->nullable();
            $table->string('business_license')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'address',
                'id_card',
                'driver_license',
                'company_name',
                'company_address',
                'business_license'
            ]);
        });
    }
}; 