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
            $table->string('order_number')->unique();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->text('delivery_address');
            $table->string('customer_email')->nullable();
            $table->boolean('terms_accepted')->default(false);
            $table->boolean('invoice_required')->default(false);
            $table->string('invoice_ruc')->nullable();
            $table->string('invoice_business_name')->nullable();
            $table->string('invoice_address')->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', [
                'received', 'confirmed', 'prepared',
                'in_transit', 'delivered', 'rescheduled', 'cancelled'
            ])->default('received');
            $table->enum('order_type', ['standard', 'express', 'pickup'])->default('standard');
            $table->enum('invoice_status', ['pending', 'paid'])->default('pending');
            $table->enum('payment_status', ['pending', 'completed'])->default('pending');
            $table->enum('payment_type', ['cash', 'digital', 'card', 'transfer'])->default('cash');
            $table->text('notes')->nullable();
            $table->timestamps();
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
