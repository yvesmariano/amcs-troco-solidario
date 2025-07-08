<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->decimal('total', 10, 2);
            $table->enum('status', ['pending', 'approved', 'canceled'])->default('pending');
            $table->foreignId('point_of_sale_id')->constrained();
            $table->foreignId('operator_id')->nullable()->constrained('users');
            $table->timestamp('paid_at')->nullable();
            $table->string('external_id', 100)->nullable();
            $table->text('qr_code_content')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
