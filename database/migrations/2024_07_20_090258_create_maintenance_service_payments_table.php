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
        Schema::create('maintenance_service_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('maintenance_service_id');
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('service_type_id');
            $table->unsignedBigInteger('service_category_id');
            $table->date('service_date');
            $table->decimal('service_cost', 10, 2);
            $table->unsignedBigInteger('account_id');
            $table->string('invoice_no');
            $table->string('receipt_type_code')->nullable();
            $table->string('payment_type_code')->nullable();
            $table->date('confirm_date')->nullable();
            $table->date('payment_date');
            $table->decimal('total_taxable_amount', 10, 2);
            $table->decimal('total_tax_amount', 10, 2)->nullable();
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->text('remark')->nullable();
            $table->string('payment_receipt')->nullable();
            $table->string('reference')->nullable();
            $table->string('qr_code_url')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            // Foreign keys and indexes
            $table->foreign('maintenance_service_id')->references('id')->on('maintenance_services')->onDelete('cascade');
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
            $table->foreign('service_type_id')->references('id')->on('service_types')->onDelete('cascade');
            $table->foreign('service_category_id')->references('id')->on('service_type_categories')->onDelete('cascade');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_service_payments');
    }
};