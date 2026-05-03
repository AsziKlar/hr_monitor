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
        Schema::create('agency_mechanism_periods', function (Blueprint $table) {
            $table->id();

            $table->foreignId('agency_id')->constrained()->cascadeOnDelete();

            $table->foreignId('mechanism_id')->constrained()->cascadeOnDelete();

            $table->unsignedInteger('current_period')->default(1);

            $table->timestamps();

            $table->unique(['agency_id', 'mechanism_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agency_mechanism_periods');
    }
};
