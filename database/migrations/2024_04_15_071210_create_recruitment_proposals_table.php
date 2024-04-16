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
        Schema::create('recruitment_proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('jobs');
            $table->integer('quantity');
            $table->text('reason');
            $table->text('requirement');
            $table->bigInteger('salary');
            $table->date('work_time');
            $table->text('note')->nullable();
            $table->enum('status', ['Mở', 'Đã kiểm tra', 'Đã duyệt']);
            $table->foreignId('creator_id')->constrained('admins');
            $table->foreignId('reviewer_id')->nullable()->constrained('admins');
            $table->enum('reviewer_result', ['Đồng ý', 'Từ chối'])->nullable();
            $table->text('reviewer_comment')->nullable();
            $table->foreignId('approver_id')->nullable()->constrained('admins');
            $table->enum('approver_result', ['Đồng ý', 'Từ chối'])->nullable();
            $table->text('approver_comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruitment_proposals');
    }
};
