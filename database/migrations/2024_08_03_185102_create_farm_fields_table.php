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
        Schema::create('farm_fields', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->enum('status', ['IDLE', 'CROP_GROWING_UP', 'CROP_GROWN_UP', 'BARREN'])->default('BARREN');
            $table->bigInteger('crop_id')->unsigned()->nullable();
            $table->date('planted_at')->nullable();
            $table->date('harvestable_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farm_fields');
    }
};
