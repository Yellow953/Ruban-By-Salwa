<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->integer('seats')->default(1);
            $table->string('location')->nullable();
            $table->enum('status', ['available', 'occupied', 'reserved', 'maintenance'])->default('available');
            $table->text('notes')->nullable();
            $table->bigInteger("business_id")->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('business_id')->references('id')->on('businesses');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
};
