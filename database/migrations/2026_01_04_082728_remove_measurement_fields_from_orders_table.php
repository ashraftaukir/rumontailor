<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Remove redundant measurement fields from orders table.
     * Measurements should only be stored in order_items table.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Remove all measurement fields - these belong in order_items table
            $table->dropColumn([
                'chest', 'waist', 'shoulder_width', 'sleeve_length', 'shirt_length', 'jacket_length',
                'neck', 'armhole', 'bicep', 'wrist', 'hip', 'inseam', 'outseam',
                'thigh', 'knee', 'ankle', 'pant_length'
            ]);
            
            // Note: Keeping 'garment_type' for backward compatibility and filtering purposes
            // It represents the primary garment type of the order (first item's type)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Re-add measurement fields if rollback is needed
            $table->decimal('chest', 5, 2)->nullable()->after('notes');
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
        });
    }
};
