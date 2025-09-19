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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable()->constrained('orders')->nullOnDelete();
            $table->string('method', 50)->nullable(); // e.g. qris, ewallet, bank_transfer, credit_card, cod
            $table->unsignedBigInteger('amount_cents');
            $table->enum('status', ['pending','paid','failed'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->string('provider_ref', 120)->nullable(); // gateway transaction id
            $table->timestamps();

            $table->index('order_id');
            $table->index('status');
            $table->index('provider_ref');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
