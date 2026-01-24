<?php

use App\Models\Asset;
use App\Models\Room;
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
        Schema::create('issuances', function(Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class, 'creator_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignIdFor(Asset::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignIdFor(Room::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignIdFor(Asset::class, 'device_id')
                ->nullable()
                ->constrained('assets')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->morphs('issuable');

            $table->integer('quantity');
            $table->string('status', 20)->index('idx-issuances-status')->default('active');
            $table->date('issued_at')->index('idx-issuances-issued_at');
            $table->date('returned_at')->nullable()->index('idx-issuances-returned_at');
            $table->text('comment');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issuances');
    }
};
