<?php

use App\Models\Wallet;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Wallet::class)
                ->index('idx-transactions-wallet_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('type', 12)->index('idx-transactions-type');
            $table->decimal('amount', 10)->index('idx-transactions-amount');
            $table->decimal('balance_before', 10)->index('idx-transactions-balance_before');
            $table->decimal('balance_after', 10)->index('idx-transactions-balance_after');
            $table->string('status', 15)->index('idx-transactions-status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
