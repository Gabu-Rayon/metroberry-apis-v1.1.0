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
        Schema::create('vehicle_refuelings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('refuelling_station_id');
            $table->unsignedBigInteger('creator_id');
            $table->date('refuelling_date');
            $table->time('refuelling_time');
            $table->decimal('refuelling_volume', 10, 2);
            $table->decimal('refuelling_cost', 10, 2);
            $table->string('attendant_name');
            $table->string('attendant_phone');
            $table->enum('status', ['pending', 'approved', 'rejected', 'billed', 'paid', 'partially paid'])->default('pending');

            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
            $table->foreign('refuelling_station_id')->references('id')->on('refuelling_stations')->onDelete('cascade');
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_refuelings');
    }
};