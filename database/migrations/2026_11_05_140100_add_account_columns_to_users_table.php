<?php

use App\Enums\AccountStatus;
use App\Enums\ProfileType;
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
            // The account's profile (ProfileType alias + id), unique: one profile per account.
            $table->string('profilable_type', 20)->nullable()->after('password');
            $table->unsignedBigInteger('profilable_id')->nullable()->after('profilable_type');
            $table->string('status', 20)->nullable()->after('profilable_id');
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

            $table->unique(['profilable_type', 'profilable_id']);
            $table->index(['profilable_type', 'status']);
        });

        // Accounts created before this migration (dev seeds, earlier environments) become active citizens
        // with their own citoyen profile, and get their e-mail lowercased, as sign-in and registration
        // only look up lowercase addresses.
        DB::table('users')->whereNull('profilable_id')->orderBy('id')->each(function (object $user): void {
            $profileId = DB::table('citoyen_profiles')->insertGetId(['created_at' => now(), 'updated_at' => now()]);

            DB::table('users')->where('id', $user->id)->update([
                'profilable_type' => ProfileType::Citoyen->value,
                'profilable_id' => $profileId,
            ]);
        });
        DB::table('users')->whereNull('status')->update(['status' => AccountStatus::Active->value]);
        DB::table('users')->update(['email' => DB::raw('lower(email)')]);

        Schema::table('users', function (Blueprint $table) {
            $table->string('profilable_type', 20)->nullable(false)->change();
            $table->unsignedBigInteger('profilable_id')->nullable(false)->change();
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
            $table->dropIndex(['profilable_type', 'status']);
            $table->dropUnique(['profilable_type', 'profilable_id']);
            $table->dropConstrainedForeignId('wilaya_id');
            $table->dropColumn([
                'profilable_type', 'profilable_id', 'status', 'status_before_suspension', 'status_reason', 'organisation', 'phone',
                'terms_version', 'terms_accepted_at', 'must_change_password', 'invitation_expires_at',
                'last_login_at', 'anonymised_at',
            ]);
        });
    }
};
