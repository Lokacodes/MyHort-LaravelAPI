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
        Schema::create('jadwal_sirams', function (Blueprint $table) {
            $table->id();
            $table->string('id_alat')->constrained('alat__io_t_s');
            $table->string('jam_on'); 
            $table->string('jam_off');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_sirams');
    }
};
