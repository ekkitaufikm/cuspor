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
        Schema::create('cp_customer_satisfaction', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sq_id');
            $table->string('satisfaction_no');
            $table->string('pic_sales');
            $table->string('cust_id');
            $table->string('cust_pic_id');
            $table->string('remarks');
            $table->string('status');
            $table->string('received_by')->nullable();
            $table->string('received_date')->nullable();
            $table->string('resolved_by')->nullable();
            $table->string('resolved_title')->nullable();
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
        Schema::dropIfExists('cp_customer_satisfaction');
    }
};
