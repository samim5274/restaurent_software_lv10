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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reg')->default(0);
            $table->date('date');
            $table->foreignId('foodId')->constrained('food');
            $table->integer('stockIn')->default(0);
            $table->integer('stockOut')->default(0);
            $table->string('remark')->nullable();
            $table->integer('status')->default('0'); // 1 sale, 2 return, 3 stock in and 4 stock out
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
