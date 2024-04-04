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
        Schema::create('phone_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('phone_number_id')->constrained('phone_numbers')->onDelete('cascade');
            $table->foreignId('offer_id')->constrained('offers');
            $table->float('offer_full_amount');
            $table->date('expiration_date');
            $table->float('offer_used_amount')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phone_offers');
    }
};
