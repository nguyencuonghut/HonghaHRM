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
        Schema::create('employee_regimes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees');
            $table->foreignId('regime_id')->constrained('regimes');
            $table->date('off_start_date')->nullable();
            $table->date('off_end_date')->nullable();
            $table->text('payment_period')->nullable();
            $table->bigInteger('payment_amount')->nullable();
            $table->enum('status', ['Mở', 'Đóng']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_regimes');
    }
};
