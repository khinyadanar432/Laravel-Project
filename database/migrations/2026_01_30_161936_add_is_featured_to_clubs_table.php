<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clubs', function (Blueprint $table) {
            // Add is_featured column if it doesn't exist
            if (!Schema::hasColumn('clubs', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('is_active');
            }
            
            // Add other missing columns from our updated migration
            $columnsToAdd = [
                'short_description' => 'text',
                'subcategory' => 'string',
                'banner_image' => 'string',
                'meeting_room' => 'string',
                'campus_location' => 'string',
                'president_id' => 'foreignId',
                'contact_email' => 'string',
                'contact_phone' => 'string',
                'social_facebook' => 'string',
                'social_instagram' => 'string',
                'social_website' => 'string',
                'current_members' => 'integer',
                'membership_type' => 'string',
                'membership_fee' => 'decimal',
                'views_count' => 'integer',
                'popularity_score' => 'integer',
                'requirements' => 'text',
                'benefits' => 'text',
                'eligibility_criteria' => 'json',
                'skills_developed' => 'json',
                'gives_certificates' => 'boolean',
                'counts_for_credit' => 'boolean',
                'founded_at' => 'timestamp',
                'created_by' => 'foreignId',
            ];
            
            foreach ($columnsToAdd as $column => $type) {
                if (!Schema::hasColumn('clubs', $column)) {
                    if ($type === 'foreignId') {
                        $table->foreignId($column)->nullable()->constrained('users');
                    } elseif ($type === 'decimal') {
                        $table->decimal($column, 10, 2)->default(0);
                    } elseif ($type === 'json') {
                        $table->json($column)->nullable();
                    } else {
                        $table->{$type}($column)->nullable();
                    }
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('clubs', function (Blueprint $table) {
            // Remove columns if needed
            $table->dropColumn('is_featured');
            // Add other columns to drop if needed
        });
    }
};