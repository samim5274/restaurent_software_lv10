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
            $table->date('date');
            $table->foreignId('user_id')->constrained('admins')->onDelete('restrict');
            $table->unsignedBigInteger('reg')->unique();
            $table->decimal('total', 12, 2)->nullable();
            $table->decimal('discount', 12, 2)->nullable();
            $table->decimal('vat', 12, 2)->nullable();
            $table->decimal('payable', 12, 2)->nullable();
            $table->decimal('pay', 12, 2)->nullable();
            $table->decimal('due', 12, 2)->nullable();
            $table->unsignedInteger('kitchen')->default(0);
            $table->Integer('paymentMethod')->constrained('payment_methods')->onDelete('restrict');
            $table->string('customerName')->default(0);
            $table->Integer('customerPhone')->default(0);
            $table->Integer('status')->default(0);
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
