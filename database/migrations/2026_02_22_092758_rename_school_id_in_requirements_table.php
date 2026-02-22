<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('requirements', function (Blueprint $table) {
        // 1. Putuskan hubungan Foreign Key-nya dulu
        // Nama index biasanya 'nama_tabel_nama_kolom_foreign'
        $table->dropForeign(['school_id']); 

        // 2. Sekarang baru aman untuk dihapus
        $table->dropColumn('school_id');

        // 3. Tambahkan kolom teks manualnya
        $table->string('school_name')->after('id')->nullable();
    });
}

public function down()
{
    Schema::table('requirements', function (Blueprint $table) {
        $table->foreignId('school_id')->nullable()->constrained('users');
        $table->dropColumn('school_name');
    });
}
};
