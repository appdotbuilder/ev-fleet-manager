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
        Schema::create('vehicle_tracking', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->foreignId('driver_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->decimal('speed', 6, 2)->nullable(); // km/h
            $table->decimal('heading', 6, 3)->nullable(); // degrees
            $table->decimal('altitude', 8, 2)->nullable(); // meters
            $table->decimal('battery_level', 5, 2)->nullable(); // percentage
            $table->decimal('odometer', 10, 2)->nullable(); // km
            $table->boolean('ignition_on')->default(false);
            $table->json('sensors')->nullable(); // additional sensor data
            $table->timestamp('recorded_at');
            $table->timestamps();
            
            $table->index(['tenant_id', 'vehicle_id', 'recorded_at']);
            $table->index(['vehicle_id', 'recorded_at']);
            $table->index(['latitude', 'longitude']);
            $table->index('recorded_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_tracking');
    }
};