<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delivery_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('delivery_location');
            $table->string('delivery_country');
            $table->string('delivery_weight')->nullable();
            $table->string('delivery_price')->nullable();
            $table->date('preferred_delivery_date')->nullable();
            $table->date('delivery_deadline')->nullable();
            $table->string('status')->default('pending');
            $table->text('delivery_note')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_requests');
    }
};
