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
        // Hapus kolom lama
        $table->dropColumn(['latitude', 'longitude']);
        
        // Tambah kolom link gmaps
        $table->text('google_maps_url')->nullable()->after('description');
    });
}

public function down()
{
    Schema::table('requirements', function (Blueprint $table) {
        $table->string('latitude')->nullable();
        $table->string('longitude')->nullable();
        $table->dropColumn('google_maps_url');
    });
}
};
