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
        Schema::create('fleet_gps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fleet_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('gps_device_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->boolean('active')->default(false);
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('unassigned_at')->nullable();
            $table->timestamps();
            $table->unique(['fleet_id', 'gps_device_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fleet_gps');
    }
};