<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cinemas', function (Blueprint $table) {
            $table->uid();
            $table->foreignUuid('city_id')->constrained()->noActionOnDelete();
            $table
                ->foreignUuid('parent_cinema_id')
                ->nullable()
                ->constrained('cinemas')
                ->noActionOnDelete();
            $table->string('title');
            $table->jsonb('address');
            $table->string('phone', 20)->index();
            $table->string('email')->index();
            $table->activeState();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cinemas');
    }
};
