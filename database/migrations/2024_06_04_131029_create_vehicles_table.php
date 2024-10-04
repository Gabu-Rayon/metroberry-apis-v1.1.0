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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->unsignedBigInteger('organisation_id')->nullable();
            $table->string('model');
            $table->string('make');
            $table->string('year');
            $table->string('plate_number')->unique();
            $table->string('color');
            $table->integer('seats');
            $table->enum('class', ['A', 'B', 'C','D','E']);
            $table->string('fuel_type');
            $table->string('engine_size');
            $table->string('avatar')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('inactive')->nullable();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('organisation_id')->references('id')->on('organisations')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};