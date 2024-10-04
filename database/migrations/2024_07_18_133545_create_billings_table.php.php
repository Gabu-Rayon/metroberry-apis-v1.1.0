<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trip_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trip_id');
            $table->unsignedBigInteger('customer_id');
            $table->string('invoice_no');
            $table->string('account_id');
            // reference the id in the accounts table 
            $table->string('customer_tin')->nullable();
            $table->string('customer_name');
            $table->string('receipt_type_code')->nullable();
            $table->string('payment_type_code')->nullable();
            $table->date('confirm_date')->nullable();
            $table->date('payment_date');
            $table->decimal('total_taxable_amount', 15, 2)->nullable();
            $table->decimal('total_tax_amount', 15, 2)->nullable();
            $table->decimal('total_amount', 15, 2);
            $table->text('remark')->nullable();
            $table->string('payment_receipt');
            $table->string('reference');
            $table->string('qr_code_url')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('trip_id')->references('id')->on('trips')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_payments');
    }
};