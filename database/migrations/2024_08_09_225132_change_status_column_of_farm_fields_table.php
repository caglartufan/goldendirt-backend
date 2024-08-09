<?php

use App\Enums\FarmFieldStatus;
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
            $table
                ->enum('status', array_column(FarmFieldStatus::cases(), 'value'))
                ->default(FarmFieldStatus::Barren->value)
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('farm_fields', function(Blueprint $table) {
            $table
                ->enum('status', ['IDLE', 'CROP_GROWING_UP', 'CROP_GROWN_UP', 'BARREN'])
                ->default('BARREN')
                ->change();
        });
    }
};
