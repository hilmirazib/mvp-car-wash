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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('partner_id')->nullable()->constrained('partners')->nullOnDelete();
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();

            // booking info
            $table->timestamp('scheduled_at');
            $table->timestamp('placed_at')->useCurrent();

            // location snapshot
            $table->text('address_text');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // price snapshot
            $table->unsignedBigInteger('price_cents');

            // status
            $table->enum('status', ['requested','accepted','in_progress','completed','cancelled'])->default('requested');
            $table->enum('payment_status', ['pending','paid','failed'])->default('pending');

            $table->text('notes')->nullable();
            $table->text('cancelled_reason')->nullable();

            $table->timestamps();

            // indexes
            $table->index(['customer_id','scheduled_at']);
            $table->index(['partner_id','scheduled_at']);
            $table->index('status');
            $table->index(['latitude','longitude']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
