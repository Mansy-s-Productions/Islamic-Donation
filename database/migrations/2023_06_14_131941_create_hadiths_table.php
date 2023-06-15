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
        Schema::create('hadiths', function (Blueprint $table) {
            $table->id();
            $table->integer('hadith_id');
            $table->text('title');
            $table->text('hadith_text');
            $table->longText('explanation');
            $table->longText('word_meanings');
            $table->longText('benefits');
            $table->string('grade');
            $table->string('takhrij');
            $table->string('link');
            $table->string('lang_code');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hadiths');
    }
};
