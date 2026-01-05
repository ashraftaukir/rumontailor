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
        Schema::create('customer_measurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->enum('garment_type', ['shirt', 'pant', 'suit'])->default('shirt');
            
            // Measurements
            $table->decimal('chest', 5, 2)->nullable();
            $table->decimal('waist', 5, 2)->nullable();
            $table->decimal('shoulder_width', 5, 2)->nullable();
            $table->decimal('sleeve_length', 5, 2)->nullable();
            $table->decimal('shirt_length', 5, 2)->nullable();
            $table->decimal('jacket_length', 5, 2)->nullable();
            $table->decimal('neck', 5, 2)->nullable();
            $table->decimal('armhole', 5, 2)->nullable();
            $table->decimal('bicep', 5, 2)->nullable();
            $table->decimal('wrist', 5, 2)->nullable();
            $table->decimal('hip', 5, 2)->nullable();
            $table->decimal('inseam', 5, 2)->nullable();
            $table->decimal('outseam', 5, 2)->nullable();
            $table->decimal('thigh', 5, 2)->nullable();
            $table->decimal('knee', 5, 2)->nullable();
            $table->decimal('ankle', 5, 2)->nullable();
            $table->decimal('pant_length', 5, 2)->nullable();
            
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Ensure one measurement record per customer per garment type
            $table->unique(['customer_id', 'garment_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_measurements');
    }
};
