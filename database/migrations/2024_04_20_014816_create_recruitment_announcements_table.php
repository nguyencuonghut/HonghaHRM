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
        Schema::create('recruitment_announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('recruitment_proposals');
            $table->enum('status', ['Chưa đăng', 'Đã đăng']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruitment_announcements');
    }
};
