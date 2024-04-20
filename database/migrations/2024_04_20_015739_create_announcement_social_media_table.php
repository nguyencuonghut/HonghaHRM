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
        Schema::create('announcement_social_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('announcement_id')->constrained('recruitment_announcements');
            $table->foreignId('social_media_id')->constrained('recruitment_social_media');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcement_social_media');
    }
};
