<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->enum('status', ['pending', 'approved', 'canceled'])->default('pending');
            $table->integer('amount')->default(0);
            $table->foreignId('customer_id')->nullable()->constrained();
            $table->foreignId('campaign_id')->nullable()->constrained();
            $table->foreignId('point_of_sale_id')->nullable()->constrained();
            $table->foreignId('operator_id')->nullable()->constrained('users');
            $table->enum('payment_method', ['credit_card', 'debit_card', 'pix', 'cash']);
            $table->timestamp('received_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
