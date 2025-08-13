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
        Schema::create('armadas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_armada_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->string('name_car');
            $table->string('plate_number')->unique();
            $table->string('color')->nullable();
            $table->integer('year')->nullable();
            $table->string('frame_number')->unique();
            $table->string('machine_number')->unique();
            $table->string('driver')->nullable();
            $table->enum('status', ['aktif', 'nonaktif', 'maintenance'])->default('aktif');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('armadas');
    }
};
