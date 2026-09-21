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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('address');
            $table->string('city')->default('Surabaya');
            $table->string('phone');
            $table->string('opening_hours')->default('10.00 - 22.00 WIB');
            $table->boolean('is_open')->default(true);
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('category'); // mie, dimsum, minuman, paket
            $table->integer('price');
            $table->text('description');
            $table->string('image');
            $table->boolean('has_spicy_level')->default(false);
            $table->integer('max_spicy_level')->default(8);
            $table->boolean('is_available')->default(true);
            $table->boolean('is_popular')->default(false);
            $table->float('rating')->default(4.8);
            $table->integer('rating_count')->default(120);
            $table->timestamps();
        });

        Schema::create('restaurant_tables', function (Blueprint $table) {
            $table->id();
            $table->string('table_number')->unique();
            $table->integer('capacity');
            $table->string('room'); // Indoor AC, Outdoor, VIP
            $table->string('status')->default('available'); // available, occupied, reserved
            $table->timestamps();
        });

        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('title');
            $table->string('discount_type'); // percent, fixed
            $table->integer('discount_value');
            $table->integer('min_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->string('order_type'); // pickup_now, pickup_scheduled, dine_in
            $table->string('table_number')->nullable();
            $table->string('pickup_time_slot')->nullable();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('payment_method')->default('qris'); // qris, cash, transfer
            $table->string('payment_status')->default('paid'); // pending, paid, failed
            $table->string('status')->default('in_kitchen'); // pending_payment, in_kitchen, ready_pickup, completed, cancelled
            $table->integer('subtotal');
            $table->integer('discount')->default(0);
            $table->integer('tax')->default(0);
            $table->integer('total');
            $table->json('items');
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
        Schema::dropIfExists('promos');
        Schema::dropIfExists('restaurant_tables');
        Schema::dropIfExists('products');
        Schema::dropIfExists('branches');
    }
};
