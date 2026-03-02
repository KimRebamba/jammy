<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('username', 50)->unique();
            $table->string('password', 255); 
            $table->string('email', 100)->unique();
            $table->string('address')->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->enum('role', ['customer', 'admin'])->default('customer');
            $table->string('first_name', 50)->nullable();
            $table->string('last_name', 50)->nullable();
            $table->string('profile_photo_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps(); 
            $table->softDeletes(); 

            $table->index('email');
            $table->index('role');
        });

        Schema::create('positions', function (Blueprint $table) {
            $table->id('position_id');
            $table->string('position_name');
            $table->decimal('monthly_rate', 12, 2)->default(0);
            $table->timestamps();

            $table->index('position_name');
        });

        Schema::create('employees', function (Blueprint $table) {
            $table->id('emp_id');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email')->unique()->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->string('address')->nullable();
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->enum('employment_status', ['active','inactive','terminated','on_leave'])->default('active');
            $table->date('hire_date')->nullable();
            $table->foreignId('current_position_id')->nullable()->constrained('positions', 'position_id')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['last_name', 'first_name']);
        });

        Schema::create('salaries', function (Blueprint $table) {
            $table->id('salary_id');
            $table->foreignId('emp_id')->constrained('employees', 'emp_id')->cascadeOnDelete();
            $table->date('pay_date');
            $table->decimal('rate_used', 12, 2)->default(0);
            $table->enum('status', ['pending','paid','cancelled'])->default('pending');
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->timestamps();

            $table->unique(['emp_id','from_date','to_date']);
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id('category_id');
            $table->string('category_name')->unique();
            $table->text('description')->nullable();
            $table->string('photo_url', 500)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('brands', function (Blueprint $table) {
            $table->id('brand_id');
            $table->string('brand_name')->unique();
            $table->string('logo_url', 500)->nullable();
            $table->string('website')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('product_name');
            $table->foreignId('brand_id')->nullable()->constrained('brands', 'brand_id')->nullOnDelete();
            $table->string('model')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('categories', 'category_id')->nullOnDelete();
            $table->decimal('retail_price', 12, 2)->default(0);
            $table->decimal('cost_price', 12, 2);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('stock_level')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('product_name');
        });

        Schema::create('product_photos', function (Blueprint $table) {
            $table->id('product_photo_id');
            $table->foreignId('product_id')->constrained('products', 'product_id')->cascadeOnDelete();
            $table->string('photo_url', 500);
            $table->boolean('is_primary')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('cart', function (Blueprint $table) {
            $table->id('cart_id');
            $table->foreignId('user_id')->unique()->constrained('accounts', 'user_id')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('cart_product', function (Blueprint $table) {
            $table->id('cart_product_id');
            $table->foreignId('cart_id')->constrained('cart', 'cart_id')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products', 'product_id')->cascadeOnDelete();
            $table->integer('quantity')->default(1);
            $table->unique(['cart_id','product_id']);
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->foreignId('user_id')->nullable()->constrained('accounts', 'user_id')->nullOnDelete();
            $table->timestamp('date_ordered')->useCurrent();
            $table->enum('payment_status', ['pending','paid','refunded'])->default('pending');
            $table->enum('order_status', ['pending','processing','shipped','completed','cancelled','requested_refund','returned'])->default('pending');
            $table->string('payment_option')->nullable();
            $table->decimal('delivery_fee', 12, 2)->default(0);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('product_order', function (Blueprint $table) {
            $table->id('product_order_id');
            $table->foreignId('order_id')->constrained('orders', 'order_id')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products', 'product_id')->restrictOnDelete();
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 12, 2)->default(0);
            $table->timestamps();

            $table->index(['order_id','product_id']);
        });

        Schema::create('order_return', function (Blueprint $table) {
            $table->id('order_return_id');
            $table->foreignId('order_id')->constrained('orders', 'order_id')->cascadeOnDelete();
            $table->string('reason')->nullable();
            $table->enum('cond', ['new','opened','damaged','other'])->default('other');
            $table->enum('return_status', ['requested','approved','rejected','processed'])->default('requested');
            $table->decimal('refund_amount', 12, 2)->default(0);
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('expenses', function (Blueprint $table) {
            $table->id('exp_id');
            $table->enum('expense_type', ['inventory_purchase','shipping','maintenance','rent','utilities','other'])->default('other');
            $table->string('description')->nullable();
            $table->decimal('amount', 12, 2)->default(0);
            $table->enum('status', ['pending','paid'])->default('pending');
            $table->date('due_date')->nullable();
            $table->date('paid_date')->nullable();
            $table->timestamps();
        });

        Schema::create('product_review', function (Blueprint $table) {
            $table->id('review_id');
            $table->foreignId('product_order_id')->constrained('product_order', 'product_order_id')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('accounts', 'user_id')->nullOnDelete();
            $table->tinyInteger('rating');
            $table->string('review_title')->nullable();
            $table->text('review_text')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamps();

            $table->unique(['user_id','product_order_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_review');
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('order_return');
        Schema::dropIfExists('product_order');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('cart_product');
        Schema::dropIfExists('cart');
        Schema::dropIfExists('product_photos');
        Schema::dropIfExists('products');
        Schema::dropIfExists('brands');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('salaries');
        Schema::dropIfExists('employees');
        Schema::dropIfExists('positions');
        Schema::dropIfExists('accounts');
    }
};