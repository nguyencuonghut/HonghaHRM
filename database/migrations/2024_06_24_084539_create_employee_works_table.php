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
        Schema::create('employee_works', function (Blueprint $table) {
            $table->id();
            $table->string('contract_code');
            $table->foreignId('employee_id')->constrained('employees');
            $table->foreignId('company_job_id')->constrained('company_jobs');
            $table->foreignId('off_type_id')->nullable()->constrained('off_types');
            $table->foreignId('on_type_id')->nullable()->constrained('on_types');
            $table->enum('status', ['On', 'Off']);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->text('off_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_works');
    }
};
