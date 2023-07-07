<?php

use App\Enums\Statuses\OrderStatus;
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
            $table->id()->startingValue(rand(1000000,9999999));

            $table->foreignUuid('customer_id')->constrained('customers')->cascadeOnDelete();

            $table->string('invoice_number')->nullable()->unique();

            $table->string('status')->default(OrderStatus::PAYMENT_PENDING->value);

            $table->foreignId('shipping_address_id')->nullable()->constrained('addresses','id')->nullOnDelete();
            $table->foreignId('billing_address_id')->nullable()->constrained('addresses','id')->nullOnDelete();

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
