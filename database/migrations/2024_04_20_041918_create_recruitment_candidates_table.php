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
        Schema::create('recruitment_candidates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('recruitment_proposals');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->date('date_of_birth');
            $table->string('cccd')->unique();
            $table->date('issued_date');
            $table->string('issued_by');
            $table->enum('gender', ['Nam', 'Nữ']);
            $table->string('cv_file');
            $table->foreignId('receive_method')->constrained('cv_receive_methods');
            $table->enum('batch', ['Đợt 1', 'Đợt 2', 'Đợt 3', 'Đợt 4', 'Đợt 5']);
            $table->foreignId('commune_id')->constrained('communes');
            $table->foreignId('creator_id')->constrained('admins');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruitment_candidates');
    }
};
