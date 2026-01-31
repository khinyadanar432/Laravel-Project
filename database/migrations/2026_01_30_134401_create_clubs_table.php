<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clubs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('short_description')->nullable();
            $table->string('category'); // Sports, Arts, Academic, Technology, etc.
            $table->string('subcategory')->nullable();
            $table->string('logo')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('banner_color')->default('#4f46e5');
            
            // Location
            $table->string('meeting_room')->nullable();
            $table->string('meeting_schedule');
            $table->string('campus_location')->default('Main Campus');
            
            // Contact
            $table->foreignId('faculty_advisor_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('president_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('social_facebook')->nullable();
            $table->string('social_instagram')->nullable();
            $table->string('social_website')->nullable();
            
            // Membership
            $table->integer('max_members')->nullable();
            $table->integer('current_members')->default(0);
            $table->enum('membership_type', ['open', 'approval_required', 'invite_only'])->default('approval_required');
            $table->decimal('membership_fee', 10, 2)->default(0);
            
            // Status
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->boolean('is_featured')->default(false);
            $table->integer('views_count')->default(0);
            $table->integer('popularity_score')->default(0);
            
            // Requirements
            $table->text('requirements')->nullable();
            $table->text('benefits')->nullable();
            $table->json('eligibility_criteria')->nullable();
            
            // Tags
            $table->json('tags')->nullable();
            $table->json('skills_developed')->nullable();
            
            // Academic
            $table->boolean('gives_certificates')->default(false);
            $table->boolean('counts_for_credit')->default(false);
            
            // Audit
            $table->timestamp('founded_at')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('restrict');
            $table->softDeletes();
            $table->timestamps();
            
            // Indexes
            $table->index(['is_active', 'is_featured']);
            $table->index(['category', 'subcategory']);
            $table->index('popularity_score');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clubs');
    }
};