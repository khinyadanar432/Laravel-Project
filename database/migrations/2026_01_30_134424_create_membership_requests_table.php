<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membership_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('club_id')->constrained()->onDelete('cascade');
            
            // Request details (more detailed than club_members table)
            $table->text('motivation_letter'); // Why they want to join
            $table->json('skills')->nullable(); // Skills they bring
            $table->json('experience')->nullable(); // Relevant experience
            $table->json('references')->nullable(); // References or recommendations
            
            // Status and processing
            $table->enum('status', ['pending', 'under_review', 'interview_scheduled', 'approved', 'rejected', 'waitlisted'])->default('pending');
            $table->text('review_notes')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users');
            $table->timestamp('reviewed_at')->nullable();
            
            // Interview details (if applicable)
            $table->timestamp('interview_scheduled_at')->nullable();
            $table->string('interview_location')->nullable();
            $table->text('interview_notes')->nullable();
            
            // Connection to club_members table when approved
            $table->foreignId('club_member_id')->nullable()->constrained('club_members')->onDelete('set null');
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index(['club_id', 'status']);
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membership_requests');
    }
};