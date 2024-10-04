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
        Schema::create('drivers_licenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('driver_id');
            $table->string('driving_license_no');
            $table->date('driving_license_date_of_issue');
            $table->date('driving_license_date_of_expiry');
            $table->string('driving_license_avatar_front')->nullable();
            $table->string('driving_license_avatar_back')->nullable();
            $table->boolean('verified')->default(false);

            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers_licenses');
    }
};
