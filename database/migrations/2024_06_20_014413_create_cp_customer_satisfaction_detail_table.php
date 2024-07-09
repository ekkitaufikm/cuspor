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
        Schema::create('cp_customer_satisfaction_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_satisfaction_id');
            $table->integer('services');
            $table->string('services_remarks');
            $table->integer('commercial_aspect');
            $table->string('commercial_aspect_remarks');
            $table->integer('delivery_material');
            $table->string('delivery_material_remarks');
            $table->integer('product_quality');
            $table->string('product_quality_remarks');
            $table->integer('services_inquiry');
            $table->integer('services_technical');
            $table->integer('services_level_alignment');
            $table->integer('commercial_level_alignment');
            $table->integer('commercial_flexibility');
            $table->integer('commercial_compliance');
            $table->integer('delivery_average');
            $table->integer('delivery_completeness');
            $table->integer('delivery_packing');
            $table->integer('product_compliant');
            $table->integer('product_certificate');
            $table->integer('product_response');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cp_customer_satisfaction_detail');
    }
};
