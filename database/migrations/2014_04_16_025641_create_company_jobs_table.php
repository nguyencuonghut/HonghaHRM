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
        Schema::create('company_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('division_id')->nullable()->constrained('divisions');
            $table->foreignId('position_id')->constrained('positions');
            $table->bigInteger('insurance_salary');
            $table->bigInteger('position_salary');
            $table->bigInteger('max_capacity_salary');
            $table->bigInteger('position_allowance');
            $table->string('recruitment_standard_file');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_jobs');
    }
};
