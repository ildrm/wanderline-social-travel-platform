<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $usesPostgis = DB::getDriverName() === 'pgsql';

        if ($usesPostgis) {
            DB::statement('CREATE EXTENSION IF NOT EXISTS postgis');
        }

        Schema::create('journey_days', function (Blueprint $table): void {
            $table->ulid('id')->primary();
            $table->foreignUlid('journey_id')->constrained('journeys')->cascadeOnDelete();
            $table->unsignedSmallInteger('position');
            $table->date('calendar_date');
            $table->string('timezone', 64);
            $table->timestampsTz();

            $table->unique(['journey_id', 'position'], 'journey_days_journey_position_unique');
            $table->unique(['journey_id', 'calendar_date'], 'journey_days_journey_date_unique');
        });

        Schema::create('locations', function (Blueprint $table) use ($usesPostgis): void {
            $table->ulid('id')->primary();
            $table->foreignUlid('journey_id')->constrained('journeys')->cascadeOnDelete();
            $table->string('name', 120);
            $table->char('country_code', 2);
            $table->string('timezone', 64);
            $table->decimal('public_latitude', 8, 5);
            $table->decimal('public_longitude', 8, 5);

            if ($usesPostgis) {
                $table->geography('public_coordinates', 'point', 4326);
                $table->geography('restricted_exact_coordinates', 'point', 4326);
                $table->spatialIndex('public_coordinates', 'locations_public_coordinates_spatial_index');
            } else {
                $table->decimal('restricted_exact_latitude', 10, 7);
                $table->decimal('restricted_exact_longitude', 10, 7);
            }

            $table->timestampsTz();
            $table->index(['journey_id', 'name'], 'locations_journey_name_index');
        });

        Schema::create('stops', function (Blueprint $table): void {
            $table->ulid('id')->primary();
            $table->foreignUlid('journey_day_id')->constrained('journey_days')->cascadeOnDelete();
            $table->foreignUlid('location_id')->constrained('locations')->cascadeOnDelete();
            $table->unsignedSmallInteger('position');
            $table->string('label', 120)->nullable();
            $table->timestampTz('arrival_at')->nullable();
            $table->timestampTz('departure_at')->nullable();
            $table->timestampsTz();

            $table->unique(['journey_day_id', 'position'], 'stops_day_position_unique');
            $table->index(['location_id', 'arrival_at'], 'stops_location_arrival_index');
        });

        Schema::create('transportation_legs', function (Blueprint $table): void {
            $table->ulid('id')->primary();
            $table->foreignUlid('journey_id')->constrained('journeys')->cascadeOnDelete();
            $table->foreignUlid('origin_stop_id')->constrained('stops')->cascadeOnDelete();
            $table->foreignUlid('destination_stop_id')->constrained('stops')->cascadeOnDelete();
            $table->unsignedSmallInteger('position');
            $table->enum('mode', ['AIR', 'RAIL', 'ROAD', 'SEA', 'WALK']);
            $table->string('provider', 120)->nullable();
            $table->timestampTz('departure_at');
            $table->timestampTz('arrival_at');
            $table->timestampsTz();

            $table->unique(['journey_id', 'position'], 'transportation_legs_journey_position_unique');
            $table->index(['origin_stop_id', 'destination_stop_id'], 'transportation_legs_stops_index');
        });

        Schema::create('activities', function (Blueprint $table): void {
            $table->ulid('id')->primary();
            $table->foreignUlid('stop_id')->constrained('stops')->cascadeOnDelete();
            $table->unsignedSmallInteger('position');
            $table->string('title', 160);
            $table->text('description')->nullable();
            $table->timestampTz('starts_at');
            $table->timestampTz('ends_at');
            $table->timestampsTz();

            $table->unique(['stop_id', 'position'], 'activities_stop_position_unique');
            $table->index(['stop_id', 'starts_at'], 'activities_stop_starts_index');
        });

        if ($usesPostgis) {
            $this->addPostgresConstraints();
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
        Schema::dropIfExists('transportation_legs');
        Schema::dropIfExists('stops');
        Schema::dropIfExists('locations');
        Schema::dropIfExists('journey_days');
    }

    private function addPostgresConstraints(): void
    {
        DB::statement('ALTER TABLE journey_days ADD CONSTRAINT journey_days_position_positive CHECK (position > 0)');
        DB::statement('ALTER TABLE locations ADD CONSTRAINT locations_public_latitude_range CHECK (public_latitude BETWEEN -90 AND 90)');
        DB::statement('ALTER TABLE locations ADD CONSTRAINT locations_public_longitude_range CHECK (public_longitude BETWEEN -180 AND 180)');
        DB::statement("ALTER TABLE locations ADD CONSTRAINT locations_country_code_format CHECK (country_code ~ '^[A-Z]{2}$')");
        DB::statement('ALTER TABLE stops ADD CONSTRAINT stops_position_positive CHECK (position > 0)');
        DB::statement('ALTER TABLE stops ADD CONSTRAINT stops_chronology CHECK (arrival_at IS NULL OR departure_at IS NULL OR departure_at >= arrival_at)');
        DB::statement('ALTER TABLE transportation_legs ADD CONSTRAINT transportation_legs_position_positive CHECK (position > 0)');
        DB::statement('ALTER TABLE transportation_legs ADD CONSTRAINT transportation_legs_distinct_stops CHECK (origin_stop_id <> destination_stop_id)');
        DB::statement('ALTER TABLE transportation_legs ADD CONSTRAINT transportation_legs_chronology CHECK (arrival_at > departure_at)');
        DB::statement('ALTER TABLE activities ADD CONSTRAINT activities_position_positive CHECK (position > 0)');
        DB::statement('ALTER TABLE activities ADD CONSTRAINT activities_chronology CHECK (ends_at > starts_at)');
    }
};
