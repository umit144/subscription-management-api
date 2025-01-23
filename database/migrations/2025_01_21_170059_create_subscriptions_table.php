<?php

use App\Models\Application;
use App\Models\Device;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Device::class)->constrained();
            $table->foreignIdFor(Application::class)->constrained();
            $table->uuid('receipt')->unique()->default(DB::raw('(UUID())'));
            $table->boolean('status')->default(false);
            $table->timestamp('expire_date')->nullable();
            $table->index(['expire_date', 'status']);
            $table->unique(['device_id', 'application_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
