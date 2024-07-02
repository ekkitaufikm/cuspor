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
            $table->integer('commercial_aspect');
            $table->string('commercial_aspect_remarks');
            $table->integer('technical_aspect');
            $table->string('technical_aspect_remarks');
            $table->integer('logistics');
            $table->string('logistics_remarks');
            $table->integer('quality');    
            $table->string('quality_remarks');
            $table->integer('telephone_reception');    
            $table->integer('time_for_quotation');    
            $table->integer('prices');    
            $table->integer('delivery_document');
            $table->integer('invoice_document');   
            $table->integer('visit_frequency_ca'); 
            $table->integer('information_product');  
            $table->integer('general_information');     
            $table->integer('technical_advice');     
            $table->integer('time_answer_tq');   
            $table->integer('visit_frequency_ta'); 
            $table->integer('average_time'); 
            $table->integer('emergency_delivery'); 
            $table->integer('delivery_reliability'); 
            $table->integer('visit_frequency_log'); 
            $table->integer('product_quality'); 
            $table->integer('non_confirmity'); 
            $table->integer('time_answer_qq'); 
            $table->integer('management_inspection'); 
            $table->integer('time_anser_quotation'); 
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
