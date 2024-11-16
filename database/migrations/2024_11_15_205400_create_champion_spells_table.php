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
            $table->string('name');
            $table->string('champion_name');
            $table->text('description');
            $table->text('tooltip');
            $table->string('image');
            $table->json('effect_amounts');
            $table->json('coefficients');
            $table->json('cost_coefficients');
            $table->json('cooldown_coefficients');
            $table->string('spell_key');
            $table->unsignedSmallInteger('priority');
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
