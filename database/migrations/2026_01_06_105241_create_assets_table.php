<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('original_name')->index('idx-assets-original_name');
            $table->string('name')->index('idx-assets-name');
            $table->string('inventory_number', 50)->nullable()->unique()->index('idx-assets-inventory_number');
            $table->string('status', 50)->default('in_stock')->index('idx-assets-status');
            $table->date('date_registration')->index('idx-assets-date_registration');
            $table->decimal('price', 10)->index('idx-assets-price');
            $table->integer('quantity')->index('idx-assets-quantity');
            $table->date('termination_date')->index('idx-assets-termination_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
