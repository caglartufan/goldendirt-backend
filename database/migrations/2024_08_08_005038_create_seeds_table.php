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
        Schema::create('seeds', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable();
            $table->unsignedMediumInteger('seconds_to_grow_up');
            $table->unsignedSmallInteger('xp_reward');
            $table->unsignedTinyInteger('level_required_to_plant');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seeds');
    }
};
