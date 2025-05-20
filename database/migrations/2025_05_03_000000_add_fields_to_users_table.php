<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->unique()->after('name');
            }
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('pelanggan')->after('email');
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->after('role');
            }
            if (!Schema::hasColumn('users', 'address')) {
                $table->string('address')->after('phone');
            }
            if (!Schema::hasColumn('users', 'id_card')) {
                $table->string('id_card')->nullable()->after('address');
            }
            if (!Schema::hasColumn('users', 'driver_license')) {
                $table->string('driver_license')->nullable()->after('id_card');
            }
            if (!Schema::hasColumn('users', 'company_name')) {
                $table->string('company_name')->nullable()->after('driver_license');
            }
            if (!Schema::hasColumn('users', 'company_address')) {
                $table->string('company_address')->nullable()->after('company_name');
            }
            if (!Schema::hasColumn('users', 'business_license')) {
                $table->string('business_license')->nullable()->after('company_address');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = [
                'username',
                'role',
                'phone',
                'address',
                'id_card',
                'driver_license',
                'company_name',
                'company_address',
                'business_license'
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
}; 