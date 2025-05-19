<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('operating_hours', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("business_id")->unsigned();
            $table->string('day');
            $table->boolean('open')->default(false);
            $table->string('opening_hour')->nullable();
            $table->string('closing_hour')->nullable();
            $table->timestamps();

            $table->foreign('business_id')->references('id')->on('businesses');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('operating_hours');
    }
};
