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
        Schema::create('first_interview_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_candidate_id')->constrained('proposal_candidate')->onDelete('cascade');
            $table->enum('result', ['Đạt', 'Không đạt'])->nullable();
            $table->foreignId('interviewer_id')->constrained('admins')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('first_interview_results');
    }
};
