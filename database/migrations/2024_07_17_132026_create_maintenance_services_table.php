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
        Schema::create('maintenance_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('creator_id');
            $table->unsignedBigInteger('service_type_id');
            $table->unsignedBigInteger('service_category_id');
            $table->date('service_date');
            $table->decimal('service_cost', 10, 2);
            $table->text('service_description');
            $table->enum('service_status', ['pending', 'billed', 'approved', 'rejected','paid','partially paid']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('maintenance_services');
    }
};