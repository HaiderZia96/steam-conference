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
        Schema::create('voucher_pdf', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('user_registration_id')->nullable();
            $table->unsignedBigInteger('conference_year_id')->nullable();
            $table->unsignedBigInteger('registration_type_id')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('branch_code')->nullable();
            $table->string('swift_code')->nullable();
            $table->string('account_title')->nullable();
            $table->string('account_no')->nullable();
            $table->string('iban_no')->nullable();
            $table->string('country_no')->nullable();
            $table->string('last_date')->nullable();
            $table->string('challan_no')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->boolean('status')->default('1')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->nullable();
            $table->foreign('user_registration_id')->references('id')->on('user_registrations')->onDelete('cascade')->nullable();
            $table->foreign('conference_year_id')->references('id')->on('conference_years')->onDelete('cascade')->nullable();
            $table->foreign('registration_type_id')->references('id')->on('registration_types')->onDelete('cascade')->nullable();
            // Define a composite key
            $table->unique(['user_id', 'conference_year_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher_pdf');
    }
};
