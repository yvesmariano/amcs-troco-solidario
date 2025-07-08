<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('donation_receipt', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donation_id')->constrained();
            $table->foreignId('receipt_id')->constrained();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donation_receipt');
    }
};
