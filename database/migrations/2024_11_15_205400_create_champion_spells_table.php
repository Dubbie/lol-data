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
        Schema::create('champion_spells', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('champion_name');
            $table->string('description');
            $table->string('tooltip');
            $table->string('image');
            $table->timestamps();

            $table->foreign('champion_name')->references('inner_name')->on('champions')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('champion_spells');
    }
};