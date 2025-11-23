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
        Schema::table('payment_proofs', function (Blueprint $table) {
            // Add missing fields from the controller
            $table->date('payment_date')->after('proof_image_path');
            $table->decimal('payment_amount', 15, 2)->after('payment_date');
            $table->string('bank_name', 100)->after('payment_amount');
            $table->string('account_name')->after('bank_name');
            
            // Fix uploaded_at to have a default value
            $table->dateTime('uploaded_at')->default(now())->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_proofs', function (Blueprint $table) {
            $table->dropColumn(['payment_date', 'payment_amount', 'bank_name', 'account_name']);
        });
    }
};
