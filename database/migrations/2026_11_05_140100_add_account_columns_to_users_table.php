<?php

use App\Enums\AccountStatus;
use App\Enums\UserRole;
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
            $table->string('role', 20)->nullable()->after('password');
            $table->string('status', 20)->nullable()->after('role');
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
        });

        // Accounts created before this migration (dev seeds, earlier environments) become active citizens
        // and get their e-mail lowercased, as sign-in and registration only look up lowercase addresses.
        DB::table('users')->whereNull('role')->update(['role' => UserRole::Citoyen->value]);
        DB::table('users')->whereNull('status')->update(['status' => AccountStatus::Active->value]);
        DB::table('users')->update(['email' => DB::raw('lower(email)')]);

        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 20)->nullable(false)->change();
            $table->string('status', 20)->nullable(false)->change();
        });

        // The plain unique index on email (kept) serves the `where email = ?` lookups; this one also
        // rejects case variants written outside the User model.
        DB::statement('CREATE UNIQUE INDEX users_email_lower_unique ON users (lower(email))');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP INDEX users_email_lower_unique');

        Schema::table('users', function (Blueprint $table) {
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
