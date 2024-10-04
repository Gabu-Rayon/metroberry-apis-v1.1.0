<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('trip_pricing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ride_type_id')->constrained('ride_type')->onDelete('cascade')->nullable();
            $table->decimal('base_price', 10, 2)->nullable();
            $table->decimal('price_per_km', 10, 2)->nullable();
            
            $table->decimal('price_per_minute', 10, 2)->nullable();
            
            $table->string('status')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_pricing');
    }
};