<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
        public function up()
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_url')->nullable();
            $table->string('name_of_website')->nullable();
            $table->text('description')->nullable();
            $table->string('station_code_prefix')->nullable();
            $table->string('maintenance_code_prefix')->nullable();
            $table->string('station_requisition_prefix')->nullable();
            $table->string('maintenance_requisition_prefix')->nullable();
            $table->string('environment')->nullable();
            $table->string('logo_white')->nullable();
            $table->string('logo_black')->nullable();
            $table->string('site_favicon')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('site_settings');
    }
};