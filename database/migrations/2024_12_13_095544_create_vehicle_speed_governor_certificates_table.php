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
        Schema::create('vehicle_speed_governor_certificates', function (Blueprint $table) {
            $table->id();
            $table->string('certificate_no');
            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('cascade');
            $table->string('class_no');
            $table->string('type_of_governor');
            $table->date('date_of_installation');
            $table->date('expiry_date');
            $table->string('certificate_copy');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicle_speed_governor_certificates');
    }

};