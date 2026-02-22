<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    // Ganti school_id menjadi school_name
  protected $fillable = [
    'school_name', 
    'subject', 
    'description', 
    'needed_hours', 
    'google_maps_url', // Tambahkan ini
    'status'
];

    // Hapus fungsi public function school() yang lama karena kita pakai teks manual sekarang

    public function assignments() {
        return $this->hasMany(Assignment::class);
    }
}