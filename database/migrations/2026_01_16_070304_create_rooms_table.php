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
        Schema::create('rooms', function(Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->integer('number')->unique()->index('idx-rooms-number');
            $table->string('type', 35)->index('idx-rooms-type');
            $table->string('building', 255)->index('idx-rooms-building');
            $table->tinyInteger('floor')->index('idx-rooms-floor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
