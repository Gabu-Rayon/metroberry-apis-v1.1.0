<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->unsignedBigInteger('route_id');
            $table->time('pick_up_time');
            $table->time('drop_off_time')->nullable();
            $table->string('pick_up_location');
            $table->string('drop_off_location')->nullable();
            $table->decimal('distance', 8, 2)->nullable();
            $table->integer('number_of_passengers')->nullable();
            $table->date('trip_date');
            $table->enum('status', ['scheduled', 'completed', 'cancelled', 'billed', 'paid', 'partially paid'])->default('scheduled');
            $table->decimal('vehicle_mileage', 8, 2)->nullable();
            $table->integer('engine_hours')->nullable();
            $table->decimal('fuel_consumed', 8, 2)->nullable();
            $table->integer('idle_time')->nullable();
            $table->unsignedBigInteger('billing_rate_id')->nullable();
            $table->unsignedBigInteger('biller')->nullable();
            $table->decimal('total_price', 8, 2)->nullable();
            $table->timestamp('billed_at')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->enum('billed_by', ['distance', 'time', 'car_class'])->nullable();
            $table->timestamps();

            // Define foreign key constraints
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('set null');
            $table->foreign('route_id')->references('id')->on('routes')->onDelete('cascade');
            $table->foreign('billing_rate_id')->references('id')->on('billing_rates')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('biller')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};