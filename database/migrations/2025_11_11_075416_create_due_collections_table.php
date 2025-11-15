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
        Schema::create('due_collections', function (Blueprint $table) {
            $table->id();
            $table->string('reg')->nullable();
            $table->decimal('total', 12, 2)->nullable();
            $table->decimal('discount', 12, 2)->nullable();
            $table->decimal('due', 12, 2)->nullable();
            $table->decimal('pay', 12, 2)->nullable();
            $table->date('payment_date')->default(now());
            $table->foreignId('user_id')->constrained('admins')->onDelete('restrict');
            $table->string('note')->default('N/A');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('due_collections');
    }
};
