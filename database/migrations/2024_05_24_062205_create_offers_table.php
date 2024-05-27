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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('current_salary');
            $table->bigInteger('desired_salary');
            $table->text('detail')->nullable();
            $table->text('note')->nullable();
            $table->enum('feedback', ['Đồng ý', 'Từ chối'])->nullable();
            $table->enum('result', ['Ký HĐLĐ', 'Ký HĐTV', 'Ký HĐHV', 'Không đạt'])->nullable();
            $table->foreignId('proposal_candidate_id')->constrained('proposal_candidate')->onDelete('cascade');
            $table->foreignId('creator_id')->constrained('admins')->onDelete('cascade');
            $table->foreignId('approver_id')->nullable()->constrained('admins')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
