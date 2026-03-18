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
        Schema::create('returns_refunds', function (Blueprint $table) {
            $table->id();
            $table->string('reason', 255);
            $table->decimal('refund_amount', 10, 2);
            $table->timestamps();

            $table->unsignedBigInteger('transaction_id');

            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('returns_refunds');
    }
};
