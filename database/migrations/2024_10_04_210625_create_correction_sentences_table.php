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
        Schema::create('correction_sentences', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('correction_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('post_sentence_id')->constrained()->onDelete('cascade');
            $table->text('corrected_text')->nullable();
            $table->text('explanation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('correction_sentences');
    }
};
