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
        Schema::create('candidate_attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('conference_year_id')->nullable();
            $table->unsignedBigInteger('candidate_id')->nullable();
            $table->integer('in_out')->nullable();
            $table->unsignedBigInteger('attendance_mark_by')->nullable();

            $table->foreign('conference_year_id')->references('id')->on('conference_years')->onDelete('cascade');
            $table->foreign('candidate_id')->references('id')->on('user_registrations')->onDelete('cascade');
            $table->foreign('attendance_mark_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_attendances');
    }
};
