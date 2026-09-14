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
        Schema::create('journeys', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignId('owner_id')->constrained('users')->restrictOnDelete();
            $table->enum('mode', ['SOCIAL', 'EXPERIENCE', 'PROFESSIONAL', 'PRIVATE_GROUP']);
            $table->string('title', 160);
            $table->enum('status', [
                'DRAFT', 'PRIVATE_PREVIEW', 'PENDING_REVIEW', 'RECRUITING',
                'MINIMUM_REACHED', 'CONFIRMED', 'FULL', 'WAITLIST_ONLY',
                'PREPARING', 'ACTIVE', 'PAUSED', 'EMERGENCY', 'COMPLETED',
                'CANCELLED', 'ARCHIVED',
            ])->default('DRAFT');
            $table->unsignedInteger('capacity');
            $table->enum('visibility', ['PRIVATE', 'UNLISTED', 'PUBLIC'])->default('PRIVATE');
            $table->string('timezone', 64);
            $table->timestampsTz();

            $table->index(['owner_id', 'created_at', 'id'], 'journeys_owner_created_id_index');
            $table->index(['visibility', 'status', 'created_at'], 'journeys_discovery_index');
        });

        if (DB::getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE journeys ADD CONSTRAINT journeys_capacity_positive CHECK (capacity > 0)');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journeys');
    }
};
