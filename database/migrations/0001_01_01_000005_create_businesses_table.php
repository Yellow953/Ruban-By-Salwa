<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('website')->nullable();
            $table->string('logo')->default('assets/images/no_img.png');
            $table->bigInteger("tax_id")->unsigned();
            $table->timestamps();

            $table->foreign('tax_id')->references('id')->on('taxes');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
