<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('route_locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('route_id');
            $table->boolean('is_start_location')->default(0);
            $table->boolean('is_end_location')->default(0);
            $table->boolean('is_waypoint')->default(0);
            $table->integer('point_order')->nullable();
            $table->string('name');

            $table->foreign('route_id')->references('id')->on('routes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_locations');
    }
};
