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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('timezone_name')->nullable();
            $table->string('phone_code')->nullable();
            $table->string('iso_2')->nullable();
            $table->string('iso_3')->nullable();
            $table->integer('numeric_code')->nullable();
            $table->string('tld')->nullable();
            $table->string('emoji')->nullable();
            $table->string('emoji_u')->nullable();
            $table->string('capital')->nullable();
            $table->string('native_name')->nullable();
            $table->double('longitude')->nullable();
            $table->double('latitude')->nullable();
            $table->boolean('status')->default(0);
            $table->unsignedBigInteger('region_id')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->unsignedBigInteger('sub_region_id')->nullable();
            $table->foreign('sub_region_id')->references('id')->on('sub_regions')->onDelete('cascade')->nullable();
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade')->nullable();
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('deleted_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
