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
        Schema::create('cp_customer_complaint_file', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_complaint_id');
            $table->string('file_lampiran')->nullable();
            $table->string('foto_lampiran')->nullable();
            $table->string('foto_after_solved')->nullable();
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
        Schema::dropIfExists('cp_customer_complaint_file');
    }
};
