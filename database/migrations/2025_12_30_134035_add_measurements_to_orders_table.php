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
        Schema::table('orders', function (Blueprint $table) {
            // Upper Body Measurements
            $table->decimal('chest', 5, 2)->nullable()->after('notes');
            $table->decimal('waist', 5, 2)->nullable();
            $table->decimal('shoulder_width', 5, 2)->nullable();
            $table->decimal('sleeve_length', 5, 2)->nullable();
            $table->decimal('shirt_length', 5, 2)->nullable();
            $table->decimal('neck', 5, 2)->nullable();
            $table->decimal('armhole', 5, 2)->nullable();
            $table->decimal('bicep', 5, 2)->nullable();
            $table->decimal('wrist', 5, 2)->nullable();
            
            // Lower Body Measurements
            $table->decimal('hip', 5, 2)->nullable();
            $table->decimal('inseam', 5, 2)->nullable();
            $table->decimal('outseam', 5, 2)->nullable();
            $table->decimal('thigh', 5, 2)->nullable();
            $table->decimal('knee', 5, 2)->nullable();
            $table->decimal('ankle', 5, 2)->nullable();
            $table->decimal('pant_length', 5, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'chest', 'waist', 'shoulder_width', 'sleeve_length', 'shirt_length',
                'neck', 'armhole', 'bicep', 'wrist', 'hip', 'inseam', 'outseam',
                'thigh', 'knee', 'ankle', 'pant_length'
            ]);
        });
    }
};
