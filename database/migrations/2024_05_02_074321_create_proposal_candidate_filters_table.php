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
        Schema::create('proposal_candidate_filters', function (Blueprint $table) {
            $table->id();
            $table->string('work_location')->nullable();
            $table->bigInteger('salary');
            $table->enum('result', ['Đạt', 'Loại']);
            $table->text('note')->nullable();
            $table->foreignId('proposal_candidate_id')->constrained('proposal_candidate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposal_candidate_filters');
    }
};
