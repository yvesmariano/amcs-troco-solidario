<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('point_of_sales', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('business_name', 100);
            $table->string('registration_number', 14);
            $table->decimal('percentage_fee', 10, 2)->default(0);
            $table->decimal('fixed_fee', 10, 2)->default(0);
            $table->foreignId('manager_id')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('point_of_sales');
    }
};
