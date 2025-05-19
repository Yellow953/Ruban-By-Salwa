<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->enum('status', ['ongoing', 'completed'])->default('ongoing');
            $table->bigInteger("user_id")->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger("business_id")->unsigned();
            $table->timestamps();

            $table->foreign('business_id')->references('id')->on('businesses');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('todos');
    }
};
