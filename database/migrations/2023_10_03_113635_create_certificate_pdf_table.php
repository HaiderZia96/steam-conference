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
        Schema::create('certificate_pdf', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('user_registration_id')->nullable();
            $table->unsignedBigInteger('conference_year_id')->nullable();
            $table->string('issue_date')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('title')->nullable();
            $table->string('name')->nullable();
            $table->string('event_name')->nullable();
            $table->string('venue')->nullable();
            $table->boolean('status')->default('1')->nullable();
            $table->unique(['user_id', 'conference_year_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_pdf');
    }
};
