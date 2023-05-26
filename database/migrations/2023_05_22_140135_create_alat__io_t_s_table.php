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
            $table->float('sensor_ph');
            $table->float('sensor_kepekatan');
            $table->float('sensor_penuh');
            $table->boolean('solenoid_tandon');
            $table->boolean('solenoid_siram');
            $table->integer('id_kebun');
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
