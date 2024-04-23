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
        Schema::create('proposal_candidate', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('recruitment_proposals');
            $table->foreignId('candidate_id')->constrained('recruitment_candidates');
            $table->string('cv_file');
            $table->foreignId('cv_receive_method_id')->constrained('cv_receive_methods');
            $table->enum('batch', ['Đợt 1', 'Đợt 2', 'Đợt 3', 'Đợt 4', 'Đợt 5']);
            $table->foreignId('creator_id')->constrained('admins');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposal_candidate');
    }
};
