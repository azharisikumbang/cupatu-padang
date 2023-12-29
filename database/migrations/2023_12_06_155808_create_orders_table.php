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
            $table->unsignedBigInteger('customer_id');
            $table->string('customer_name');
            $table->text('customer_address');
            $table->string('customer_contact');
            $table->decimal('order_price_total')->default(0);
            $table->decimal('order_shipping_cost')->default(0);
            $table->text('order_shipping_address');
            $table->string('order_status');
            $table->text('order_notes')->nullable();
            $table->dateTime('est_date_completion');
            $table->string('courier_name')->nullable();
            $table->string('courier_contact')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('users');
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
