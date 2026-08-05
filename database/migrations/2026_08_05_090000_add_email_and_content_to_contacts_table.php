<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The contact form collects an email address and a message, and until now neither had
 * anywhere to go: the row saved name, phone and address only, so the message survived
 * exclusively in the Telegram notification. If that notification failed, or the team
 * cleared the chat, the enquiry was gone.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            if (!Schema::hasColumn('contacts', 'email')) {
                $table->string('email', 191)->nullable()->after('phone');
            }
            if (!Schema::hasColumn('contacts', 'content')) {
                $table->text('content')->nullable()->after('address');
            }
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            foreach (['email', 'content'] as $column) {
                if (Schema::hasColumn('contacts', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
