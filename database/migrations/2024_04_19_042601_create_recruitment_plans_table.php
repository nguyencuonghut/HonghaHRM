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
        Schema::create('recruitment_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->nullable()->constrained('recruitment_proposals');
            $table->bigInteger('budget')->nullable();
            $table->foreignId('creator_id')->constrained('admins');
            $table->foreignId('approver_id')->nullable()->constrained('admins');
            $table->enum('approver_result', ['Đồng ý', 'Từ chối'])->nullable();
            $table->text('approver_comment')->nullable();
            $table->enum('status', ['Mở', 'Đã duyệt']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruitment_plans');
    }
};
