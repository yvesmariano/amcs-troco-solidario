<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->integer('amount')->nullable();
            $table->foreignId('point_of_sale_id')->constrained();
            $table->foreignId('operator_id')->constrained('users');
            $table->enum('payment_method', ['credit_card', 'debit_card', 'pix', 'cash']);
            $table->string('transaction_id')->nullable();
            $table->string('transaction_proof')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
