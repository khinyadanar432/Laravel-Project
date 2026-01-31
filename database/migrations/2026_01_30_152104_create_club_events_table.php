<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('club_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('club_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('short_description')->nullable();
            
            // Event type and category
            $table->enum('type', ['meeting', 'workshop', 'competition', 'social', 'training', 'seminar', 'other'])->default('meeting');
            $table->string('category')->nullable();
            
            // Timing
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->boolean('is_all_day')->default(false);
            $table->boolean('is_recurring')->default(false);
            $table->string('recurring_pattern')->nullable(); // weekly, monthly, etc.
            
            // Location
            $table->string('location');
            $table->string('room_number')->nullable();
            $table->boolean('is_online')->default(false);
            $table->string('online_link')->nullable();
            $table->string('meeting_platform')->nullable(); // Zoom, Google Meet, etc.
            
            // Capacity and registration
            $table->integer('max_attendees')->nullable();
            $table->integer('current_attendees')->default(0);
            $table->boolean('requires_rsvp')->default(false);
            $table->timestamp('rsvp_deadline')->nullable();
            $table->decimal('fee', 10, 2)->nullable();
            
            // Event details
            $table->string('featured_image')->nullable();
            $table->json('tags')->nullable();
            $table->json('speakers')->nullable(); // Array of speaker names/IDs
            $table->text('prerequisites')->nullable();
            $table->text('learning_outcomes')->nullable();
            
            // Status
            $table->boolean('is_published')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_cancelled')->default(false);
            $table->text('cancellation_reason')->nullable();
            
            // Attendance tracking
            $table->boolean('requires_attendance')->default(false);
            $table->string('attendance_code')->nullable(); // For QR code check-in
            
            // Audit
            $table->foreignId('created_by')->constrained('users');
            $table->integer('views_count')->default(0);
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index(['club_id', 'start_time']);
            $table->index(['start_time', 'is_published']);
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('club_events');
    }
};