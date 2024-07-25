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
        Schema::create('employee_salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees');
            $table->bigInteger('insurance_salary');
            $table->bigInteger('position_salary');
            $table->bigInteger('capacity_salary');
            $table->bigInteger('position_allowance');
            $table->date('start_date'); // Ngày bắt đầu áp dụng lương
            $table->date('end_date')->nullable(); // Ngày kết thúc áp dụng lương
            $table->enum('status', ['On', 'Off']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_salaries');
    }
};
