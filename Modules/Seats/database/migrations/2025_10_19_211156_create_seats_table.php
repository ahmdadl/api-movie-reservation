<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Seats\Enums\SeatType;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->uid();
            $table->foreignUuid('screen_id')->constrained();
            $table->string('type', 30)->default(SeatType::NORMAL->value);
            $table->integer('row');
            $table->integer('column');
            $table->activeState();
            $table->sortOrder();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
