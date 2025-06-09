<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('ktp_path')->nullable()->after('email');
            $table->string('sim_path')->nullable()->after('ktp_path');
            $table->enum('document_status', ['pending', 'approved', 'rejected'])->default('pending')->after('sim_path');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['ktp_path', 'sim_path', 'document_status']);
        });
    }
};
