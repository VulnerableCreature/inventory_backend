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
        Schema::create('employees', function(Blueprint $table) {
            $table->id();
            $table->string('surname', 50)->index('idx-employees-surname');
            $table->string('name', 50)->index('idx-employees-name');
            $table->string('middleName', 50)->index('idx-employees-middleName');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
