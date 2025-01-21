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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('uid', 64);
            $table->string('app_id', 32);
            $table->string('os', 10);
            $table->string('language', 5);
            $table->string('client_token', 64)->unique();
            $table->index(['uid', 'app_id'], 'idx_uid_app');
            $table->index('client_token', 'idx_client_token');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
