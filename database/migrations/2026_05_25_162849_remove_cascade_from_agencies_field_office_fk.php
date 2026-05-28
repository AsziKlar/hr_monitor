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
        Schema::table('agencies', function (Blueprint $table) {
            $table->dropForeign(['field_office_id']);
            $table->foreign('field_office_id')->references('id')->on('field_offices')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agencies', function (Blueprint $table) {
              $table->dropForeign(['field_office_id']);

            $table->foreign('field_office_id')
                ->references('id')
                ->on('field_offices')
                ->cascadeOnDelete();
        });
    }
};
