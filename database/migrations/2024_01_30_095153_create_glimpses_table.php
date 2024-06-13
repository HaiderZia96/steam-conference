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
        Schema::create('glimpses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('glimpse_category_id')->nullable();
            $table->unsignedBigInteger('glimpse_year_id')->nullable();
            $table->unsignedBigInteger('glimpse_day_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade')->nullable();
            $table->foreign('glimpse_category_id')->references('id')->on('glimpse_categories')->onDelete('cascade')->nullable();
            $table->foreign('glimpse_year_id')->references('id')->on('glimpse_years')->onDelete('cascade')->nullable();
            $table->foreign('glimpse_day_id')->references('id')->on('glimpse_days')->onDelete('cascade')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('glimpses');
    }
};
