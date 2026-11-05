<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * One table per account profile (ProfileType). The link is held by the user
 * (users.profilable_type / profilable_id), so the profile tables have no user_id.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin_profiles', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_super_admin')->default(false);
            $table->timestampsTz();
        });

        Schema::create('entrepreneur_profiles', function (Blueprint $table) {
            $table->id();
            $table->timestampsTz();
        });

        Schema::create('accompagnateur_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('fonction', 150);
            $table->smallInteger('capacity')->default(0);
            $table->text('presentation')->nullable();
            $table->timestampsTz();
        });

        Schema::create('trainer_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('linkedin_url', 300)->nullable();
            $table->string('education', 300);
            $table->timestampTz('test_passed_at')->nullable();
            $table->timestampsTz();
        });

        Schema::create('citoyen_profiles', function (Blueprint $table) {
            $table->id();
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citoyen_profiles');
        Schema::dropIfExists('trainer_profiles');
        Schema::dropIfExists('accompagnateur_profiles');
        Schema::dropIfExists('entrepreneur_profiles');
        Schema::dropIfExists('admin_profiles');
    }
};
