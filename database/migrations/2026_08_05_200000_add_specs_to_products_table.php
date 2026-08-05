<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Per-template specifications.
 *
 * The detail page's "Thông số kỹ thuật" tab listed eight lines and only three came from
 * the record: the code, the warranty and the catalogue. The rest — platform, responsive,
 * admin panel, what is delivered — were written into the Blade file, which meant all 36
 * templates claimed the same stack whether or not it was true, and the client could not
 * correct a single one without a deploy.
 *
 * One text column, one line per row, "Nhãn: Giá trị". A table of its own would be the
 * textbook answer and the wrong one here: there is no screen to manage it, and a textarea
 * the client can actually use beats a relation nobody can edit.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'specs')) {
                $table->text('specs')->nullable()->after('warranty');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'specs')) {
                $table->dropColumn('specs');
            }
        });
    }
};
