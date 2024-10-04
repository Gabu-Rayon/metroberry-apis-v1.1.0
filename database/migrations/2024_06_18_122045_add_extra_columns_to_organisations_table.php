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
        Schema::table('organisations', function (Blueprint $table) {
            $table->string('certificate_of_organisation')->nullable()->after('user_id');
            $table->string('billing_cycle')->nullable()->after('certificate_of_organisation');
            $table->tinyInteger('terms_and_conditions')->nullable()->after('billing_cycle');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organisations', function (Blueprint $table) {
            $table->dropColumn([
                'certificate_of_organisation',
                'billing_cycle',
                'terms_and_conditions',
            ]);
        });
    }
};
