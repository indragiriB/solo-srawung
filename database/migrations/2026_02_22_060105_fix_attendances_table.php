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
        // Cek jika kolom belum ada, baru tambahkan
        if (!Schema::hasColumn('attendances', 'user_id')) {
            $table->foreignId('user_id')->after('id')->constrained()->onDelete('cascade');
        }
        
        if (!Schema::hasColumn('attendances', 'photo')) {
            $table->string('photo')->nullable()->after('requirement_id');
        }

        if (!Schema::hasColumn('attendances', 'status')) {
            $table->string('status')->default('valid')->after('check_in');
        }
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            //
        });
    }
};
