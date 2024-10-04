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
        Schema::create('ntsa_inspection_certificates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('creator_id');
            $table->string('ntsa_inspection_certificate_no');
            $table->date('ntsa_inspection_certificate_date_of_issue');
            $table->date('ntsa_inspection_certificate_date_of_expiry');
            $table->string('ntsa_inspection_certificate_avatar')->nullable();
            $table->boolean('verified')->default(false);

            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ntsa_inspection_certificates');
    }
};
