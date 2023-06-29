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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();

            $table->foreignUuid('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->string('name');
            $table->string('address_line_one');
            $table->string('address_line_two')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
