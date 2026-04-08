<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('language_id')->constrained()->cascadeOnDelete();
            $table->integer('number');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('xp_required')->default(0);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['language_id', 'number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('levels');
    }
};
