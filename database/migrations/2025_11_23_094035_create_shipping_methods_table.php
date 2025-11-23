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
        Schema::create('shipping_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "JNT Express"
            $table->string('code')->unique(); // e.g., "jnt", "gojek"
            $table->text('description')->nullable();
            $table->decimal('base_cost', 10, 2)->default(0); // Base shipping cost
            $table->string('icon')->nullable(); // Emoji or icon identifier
            $table->integer('estimated_days')->default(1); // Estimated delivery days
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0); // Display order
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_methods');
    }
};
