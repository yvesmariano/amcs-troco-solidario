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
        Schema::rename('operator_point_of_sale', 'operators');

        Schema::table('operators', function (Blueprint $table) {
            $table->renameColumn('operator_id', 'user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('operators', 'operator_point_of_sale');

        Schema::table('operator_point_of_sale', function (Blueprint $table) {
            $table->renameColumn('user_id', 'operator_id');
        });
    }
};
