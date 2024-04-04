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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->float('price');
            $table->float('bonus_points')->default(0);
            $table->integer('offer_number')->default(0);
            $table->integer('duration_in_hours');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->softDeletes(); // because if the user already activate the offer should wait until all previous activation ends
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
