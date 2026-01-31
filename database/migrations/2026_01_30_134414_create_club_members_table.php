<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('club_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('club_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['pending', 'active', 'rejected', 'suspended', 'alumni'])->default('pending');
            $table->enum('role', ['member', 'treasurer', 'secretary', 'vice_president', 'president', 'advisor'])->default('member');
            
            // Make these nullable
            $table->text('application_message')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->json('application_answers')->nullable();
            
            // Timestamps - make joined_at nullable since it's not set for pending requests
            $table->timestamp('applied_at')->useCurrent();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('joined_at')->nullable();  // FIXED: Make nullable
            $table->timestamp('left_at')->nullable();
            $table->timestamp('suspended_until')->nullable();
            
            // Member details
            $table->json('achievements')->nullable();
            $table->integer('attendance_count')->default(0);
            $table->decimal('fees_paid', 10, 2)->default(0);
            $table->boolean('is_fee_paid')->default(false);
            $table->integer('points')->default(0);
            
            // Approval info
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            
            $table->timestamps();
            $table->softDeletes();
            
            // Unique constraint
            $table->unique(['user_id', 'club_id', 'status']);
            
            // Indexes
            $table->index(['club_id', 'status']);
            $table->index(['user_id', 'status']);
            $table->index('points');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('club_members');
    }
};