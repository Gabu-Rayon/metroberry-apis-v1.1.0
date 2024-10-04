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
        Schema::create('vehicle_insurances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('insurance_company_id');
            $table->string('insurance_policy_no');
            $table->date('insurance_date_of_issue');
            $table->date('insurance_date_of_expiry');
            $table->integer('charges_payable');
            $table->unsignedBigInteger('recurring_period_id');
            $table->date('recurring_date');
            $table->boolean('reminder');
            $table->integer('deductible');
            $table->boolean('status');
            $table->string('remark')->nullable();
            $table->string('policy_document');
            $table->unsignedBigInteger('created_by');

            $table->timestamps();

            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
            $table->foreign('insurance_company_id')->references('id')->on('insurance_companies')->onDelete('cascade');
            $table->foreign('recurring_period_id')->references('id')->on('insurance_recurring_periods')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_insurances');
    }
};