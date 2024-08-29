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
        Schema::create('increase_decrease_insurances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_work_id')->constrained('employee_works');
            $table->boolean('is_increase')->default(false);
            $table->date('increase_confirmed_month')->nullable();
            $table->boolean('is_decrease')->default(false);
            $table->date('decrease_confirmed_month')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('increase_decrease_insurances');
    }
};
