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
        Schema::create('maintenance_repairs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('creator_id');
            $table->unsignedBigInteger('part_id');
            $table->date('repair_date');
            $table->enum('repair_type', ['repair', 'replacement', 'refill']);
            $table->decimal('repair_cost', 10, 2);
            $table->decimal('amount', 10, 2)->nullable();
            $table->text('repair_description')->nullable();
            $table->enum('repair_status', ['pending', 'billed', 'approved', 'rejected','paid','partially paid']);
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('part_id')->references('id')->on('vehicle_parts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_repairs');
    }
};