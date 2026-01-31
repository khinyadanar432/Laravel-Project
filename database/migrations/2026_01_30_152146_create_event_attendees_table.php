<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_attendees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('club_events')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('club_id')->constrained()->onDelete('cascade');
            
            // RSVP status
            $table->enum('status', ['registered', 'attended', 'cancelled', 'no_show', 'waiting'])->default('registered');
            
            // Registration details
            $table->boolean('has_paid')->default(false);
            $table->decimal('amount_paid', 10, 2)->nullable();
            $table->text('registration_notes')->nullable();
            $table->json('registration_answers')->nullable(); // For custom registration questions
            
            // Check-in
            $table->timestamp('checked_in_at')->nullable();
            $table->string('checkin_method')->nullable(); // qr_code, manual, etc.
            $table->foreignId('checked_in_by')->nullable()->constrained('users');
            
            // Feedback
            $table->integer('rating')->nullable(); // 1-5 stars
            $table->text('feedback')->nullable();
            
            $table->timestamps();
            
            // One registration per user per event
            $table->unique(['event_id', 'user_id']);
            
            // Indexes
            $table->index(['event_id', 'status']);
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_attendees');
    }
};