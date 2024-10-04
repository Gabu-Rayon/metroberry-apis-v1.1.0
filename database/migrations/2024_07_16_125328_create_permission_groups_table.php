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
        // Schema::create('permission_groups', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('permission_name');
        //     $table->enum('group_name', [                
        //         'settings',
        //         'dashboard',
        //         'employee',
        //         'organisation',
        //         'drivers',
        //         'license',
        //         'psv_badge',
        //         'driver_performance',
        //         'vehicle',
        //         'vehicle_insurance',
        //         'route',
        //         'route_location',
        //         'trip',
        //         'insurance_company',
        //         'vehicle_maintenance',
        //         'account_setting',
        //     ]);

        //     $table->unique(['permission_name', 'group_name']);
        //     $table->foreign('permission_name')->references('name')->on('permissions')->onDelete('cascade');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_groups');
    }
};
