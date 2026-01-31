<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add profile fields if they don't exist
            $columns = [
                'student_id' => 'string',
                'phone' => 'string',
                'profile_photo' => 'string',
                'year_level' => 'string',
                'department' => 'string',
                'bio' => 'text',
                'interests' => 'json',
                'date_of_birth' => 'date',
                'gender' => 'enum',
                'address' => 'text',
                'emergency_contact' => 'string',
                'blood_group' => 'string',
                'allergies' => 'text',
                'academic_year' => 'string',
                'enrollment_date' => 'date',
            ];
            
            foreach ($columns as $column => $type) {
                if (!Schema::hasColumn('users', $column)) {
                    if ($type === 'enum') {
                        $table->enum($column, ['male', 'female', 'other'])->nullable();
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
        Schema::table('users', function (Blueprint $table) {
            // Remove columns if needed
            $table->dropColumn([
                'student_id', 'phone', 'profile_photo', 'year_level',
                'department', 'bio', 'interests', 'date_of_birth',
                'gender', 'address', 'emergency_contact', 'blood_group',
                'allergies', 'academic_year', 'enrollment_date'
            ]);
        });
    }
};