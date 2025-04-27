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
        Schema::create('fpga_standards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fpga_component_id')->constrained('fpga_components')->onDelete('cascade');
            $table->foreignId('standard_id')->constrained('standards')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fpga_standards');
    }
};
