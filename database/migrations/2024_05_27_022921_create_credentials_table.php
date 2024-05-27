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
        Schema::create('credentials', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('refresh_token')->nullable();
            $table->text('access_token')->nullable();
            $table->text('app_token')->nullable();
            $table->dateTime('rf_token_valid_till')->nullable();
            $table->dateTime('access_token_valid_till')->nullable();
            $table->dateTime('app_token_valid_till')->nullable();
            $table->string('environment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credentials');
    }
};
