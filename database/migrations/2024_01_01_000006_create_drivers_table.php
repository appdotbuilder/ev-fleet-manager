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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('license_number')->unique();
            $table->date('license_expiry');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->json('certifications')->nullable();
            $table->decimal('rating', 3, 2)->default(5.00);
            $table->integer('total_trips')->default(0);
            $table->decimal('total_distance', 10, 2)->default(0);
            $table->timestamps();
            
            $table->index(['tenant_id', 'status']);
            $table->index('email');
            $table->index('license_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};