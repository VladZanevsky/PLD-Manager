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
        Schema::create('fpga_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manufacturer_id')->constrained()->onDelete('cascade');
            $table->string('model', 100);
            $table->integer('frequency');
            $table->integer('lut_count');
            $table->float('power');
            $table->integer('io_count');
            $table->decimal('cost', 10, 2);
            $table->string('availability', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fpga_components');
    }
};
