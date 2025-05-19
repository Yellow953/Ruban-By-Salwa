<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->string('type')->nullable();
            $table->string('google_maps_link')->nullable();
            $table->boolean('menu_activated')->default(false);
            $table->boolean('ordering_activated')->default(false);
            $table->boolean('delivery_activated')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('google_maps_link');
            $table->dropColumn('menu_activated');
            $table->dropColumn('ordering_activated');
            $table->dropColumn('delivery_activated');
        });
    }
};
