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
        Schema::create('partner_services', function (Blueprint $table) {
            $table->foreignId('partner_id')->constrained('partners')->cascadeOnDelete();
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();
            $table->unsignedBigInteger('price_cents'); 
            $table->unsignedInteger('duration_min')->default(60);
            $table->timestamps();
            $table->primary(['partner_id','service_id']);
            $table->index('service_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_services');
    }
};
