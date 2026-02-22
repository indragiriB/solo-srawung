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
    Schema::table('attendances', function (Blueprint $table) {
        // Kita cek dulu biar tidak error "Duplicate" lagi
        if (!Schema::hasColumn('attendances', 'photo_out')) {
            $table->string('photo_out')->nullable()->after('photo');
        }
    });
}

public function down(): void
{
    Schema::table('attendances', function (Blueprint $table) {
        $table->dropColumn('photo_out');
    });
}
};
