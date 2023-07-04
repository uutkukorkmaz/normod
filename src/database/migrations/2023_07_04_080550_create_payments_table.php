<?php

use App\Enums\Statuses\PaymentStatus;
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
        /**
         * DEVELOPER'S NOTE:
         *
         * In the ideal universe of microservices, this should be in separate database and/or service.
         */
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->string('method'); // App\Enums\PaymentMethod
            $table->unsignedBigInteger('total_amount');
            $table->string('currency')->default(config('app.currency'));
            $table->string('status')->default(PaymentStatus::Pending->value);
            // there should some more additional detail columns...
            $table->timestamps();
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
