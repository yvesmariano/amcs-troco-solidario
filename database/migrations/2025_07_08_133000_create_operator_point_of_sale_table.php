<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('operator_point_of_sale', function (Blueprint $table) {
            $table->id();
            $table->foreignId('operator_id')->constrained('users');
            $table->foreignId('point_of_sale_id')->constrained();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('operator_point_of_sale');
    }
};
