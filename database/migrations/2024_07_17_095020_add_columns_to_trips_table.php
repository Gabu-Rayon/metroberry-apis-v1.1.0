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
        Schema::table('trips', function (Blueprint $table) {
            // $table->unsignedBigInteger('billing_rate_id')->nullable();
            // $table->enum('billed_by', ['distance', 'car_class', 'time'])->nullable();
            // $table->decimal('total_price', 10, 2)->nullable();
            // $table->timestamp('billed_at')->nullable();

            // $table->foreign('billing_rate_id')->references('id')->on('billing_rates');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            //
        });
    }
};
