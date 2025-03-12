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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('days', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('muscle_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('city_id');
            $table->string('street');
            $table->string('street_number');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
        });

        Schema::create('gyms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('address_id');
            $table->string('url');
            $table->string('price_group');
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
        });

        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('muscle_group_id');
            $table->string('image');
            $table->string('video');
            $table->foreign('muscle_group_id')->references('id')->on('muscle_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercises');
        Schema::dropIfExists('gyms');
        Schema::dropIfExists('addresses');
        Schema::dropIfExists('muscle_groups');
        Schema::dropIfExists('days');
        Schema::dropIfExists('cities');
    }
};
