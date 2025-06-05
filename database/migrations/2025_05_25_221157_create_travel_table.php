<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('travels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('from_country');
            $table->foreignId('to_country');
            $table->string('from_location');
            $table->string('to_location');
            $table->dateTime('departure_date');
            $table->dateTime('arrival_date');
            $table->string('weight_available')->nullable();
            $table->string('weight_price')->nullable();
            $table->string('airline')->nullable();
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('travel');
    }
};
