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
        Schema::create('refuelling_stations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('station_code');
            $table->string('certificate_of_operations');
            $table->enum('payment_period', ['daily', 'weekly', 'monthly', 'quarterly', 'biannually', 'annually']);
            $table->enum('status', ['active', 'inactive'])->default('inactive');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refuelling_stations');
    }
};
