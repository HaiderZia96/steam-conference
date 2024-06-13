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
        Schema::create('voucher_pdf_fee_head', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('voucher_pdf_id')->nullable();
            $table->string('head')->nullable();
            $table->string('amount')->nullable();
            $table->foreign('voucher_pdf_id')->references('id')->on('voucher_pdf')->onDelete('cascade')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher_pdf_fee_head');
    }
};
