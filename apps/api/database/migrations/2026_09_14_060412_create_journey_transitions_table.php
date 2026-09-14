<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('journey_transitions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('journey_id')->constrained('journeys')->cascadeOnDelete();
            $statuses = [
                'DRAFT', 'PRIVATE_PREVIEW', 'PENDING_REVIEW', 'RECRUITING',
                'MINIMUM_REACHED', 'CONFIRMED', 'FULL', 'WAITLIST_ONLY',
                'PREPARING', 'ACTIVE', 'PAUSED', 'EMERGENCY', 'COMPLETED',
                'CANCELLED', 'ARCHIVED',
            ];
            $table->enum('from_status', $statuses);
            $table->enum('to_status', $statuses);
            $table->foreignId('actor_id')->constrained('users')->restrictOnDelete();
            $table->text('note')->nullable();
            $table->timestampTz('transitioned_at');

            $table->index(['journey_id', 'transitioned_at', 'id'], 'journey_transitions_history_index');
        });

        if (DB::getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE journey_transitions ADD CONSTRAINT journey_transitions_status_changed CHECK (from_status <> to_status)');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journey_transitions');
    }
};
