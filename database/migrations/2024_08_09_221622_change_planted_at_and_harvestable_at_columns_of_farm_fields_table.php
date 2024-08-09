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
        Schema::table('farm_fields', function(Blueprint $table) {
            $table->timestamp('planted_at')->nullable()->change();
            $table->timestamp('harvestable_at')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('farm_fields', function(Blueprint $table) {
            $table->date('planted_at')->nullable()->change();
            $table->date('harvestable_at')->nullable()->change();
        });
    }
};
