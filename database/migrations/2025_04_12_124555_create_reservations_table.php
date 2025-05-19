<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('table_id')->constrained()->onDelete('cascade');
            $table->dateTime('reservation_time');
            $table->integer('number_of_people')->default(1);
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'canceled', 'completed'])->default('pending');
            $table->bigInteger("business_id")->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('business_id')->references('id')->on('businesses');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
