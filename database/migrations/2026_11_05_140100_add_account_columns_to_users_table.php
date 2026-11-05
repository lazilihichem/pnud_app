<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 20)->after('password');
            $table->string('status', 20)->after('role');
            $table->string('status_before_suspension', 20)->nullable()->after('status');
            $table->text('status_reason')->nullable()->after('status_before_suspension');
            $table->string('organisation', 150)->nullable()->after('status_reason');
            $table->foreignId('wilaya_id')->nullable()->after('organisation')->constrained()->restrictOnDelete();
            $table->string('phone', 13)->nullable()->after('wilaya_id');
            $table->string('terms_version', 20)->nullable()->after('email_verified_at');
            $table->timestampTz('terms_accepted_at')->nullable()->after('terms_version');
            $table->boolean('must_change_password')->default(false)->after('terms_accepted_at');
            $table->timestampTz('invitation_expires_at')->nullable()->after('must_change_password');
            $table->timestampTz('last_login_at')->nullable();
            $table->timestampTz('anonymised_at')->nullable();

            $table->index(['role', 'status']);
            $table->dropUnique(['email']);
        });

        DB::statement('CREATE UNIQUE INDEX users_email_lower_unique ON users (lower(email))');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP INDEX users_email_lower_unique');

        Schema::table('users', function (Blueprint $table) {
            $table->unique('email');
            $table->dropIndex(['role', 'status']);
            $table->dropConstrainedForeignId('wilaya_id');
            $table->dropColumn([
                'role', 'status', 'status_before_suspension', 'status_reason', 'organisation', 'phone',
                'terms_version', 'terms_accepted_at', 'must_change_password', 'invitation_expires_at',
                'last_login_at', 'anonymised_at',
            ]);
        });
    }
};
