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
        Schema::create('employee_appendixes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('employee_id')->constrained('employees');
            $table->foreignId('employee_contract_id')->constrained('employee_contracts');
            $table->text('description');
            $table->enum('reason', ['Điều chỉnh lương', 'Điều chỉnh chức danh', 'Khác']);
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_appendixes');
    }
};
