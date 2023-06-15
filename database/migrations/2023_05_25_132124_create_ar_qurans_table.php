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
        Schema::create('ar_qurans', function (Blueprint $table) {
            $table->id();
            $table->integer('ar_sura_number');
            $table->string('sura_ar_name');
            $table->integer('aya_number');
            $table->longText('aya_formed_text');
            $table->longText('aya_text');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ar_qurans');
    }
};
