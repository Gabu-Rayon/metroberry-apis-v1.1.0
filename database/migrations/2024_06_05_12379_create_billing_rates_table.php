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
        Schema::create('billing_rates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('rate_per_km', 8, 2);
            $table->decimal('rate_per_minute', 8, 2);
            $table->json('rate_by_car_class');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billing_rates');
    }
};
