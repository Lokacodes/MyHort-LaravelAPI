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
        Schema::create('alat__io_t_s', function (Blueprint $table) {
            $table->id();
            $table->float('sensor_kepekatan')->default(0);
            $table->float('sensor_penuh')->default(0);
            $table->float('tinggi_tandon')->default(0);
            $table->float('sensor_suhu')->default(0);
            $table->float('sensor_kelembapan')->default(0);
            $table->boolean('solenoid_tandon')->default(0);
            $table->boolean('solenoid_siram')->default(0);
            $table->string('id_alat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alat__io_t_s');
    }
};
