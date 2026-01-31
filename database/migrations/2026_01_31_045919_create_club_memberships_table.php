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
        Schema::create('club_memberships', function (Blueprint $table) {
        $table->id();
        $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('club_id')->constrained()->onDelete('cascade');
        $table->enum('status', ['pending', 'active', 'rejected', 'archived'])->default('pending');
        $table->string('role')->default('member');
        $table->timestamp('joined_at')->nullable();
        $table->text('notes')->nullable();
        $table->timestamps();
        
        $table->unique(['student_id', 'club_id']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('club_memberships');
    }
};
