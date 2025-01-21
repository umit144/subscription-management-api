<?php

use App\Models\Application;
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
        Schema::create('application_credentials', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Application::class);
            $table->string('platform', 10);
            $table->string('username', 64);
            $table->string('password', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_credentials');
    }
};
