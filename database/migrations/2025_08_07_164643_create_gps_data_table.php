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
        Schema::create('gps_data', function (Blueprint $table) {
            $table->id();
            $table->string('device_id');
            $table->decimal('latitude', 10, 6);
            $table->decimal('longitude', 10, 6);
            $table->float('speed')->nullable();
            $table->float('course')->nullable();
            $table->string('direction')->nullable();
            $table->timestamp('devices_timestamp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gps_data');
    }
};
