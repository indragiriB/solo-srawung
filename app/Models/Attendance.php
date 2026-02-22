<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
protected $fillable = [
    'user_id', 
    'volunteer_id', 
    'requirement_id', 
    'photo', 
    'photo_out', // Pastikan ini ada
    'check_in', 
    'check_out', // Pastikan ini ada
    'status'
];
protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime',
    ];

// Di dalam class Attendance extends Model
public function getDurationAttribute()
{
    if (!$this->check_in || !$this->check_out) {
        return '0 jam';
    }

    $masuk = Carbon::parse($this->check_in);
    $keluar = Carbon::parse($this->check_out);

    // Menghitung selisih
    $totalMenit = $masuk->diffInMinutes($keluar);
    $jam = floor($totalMenit / 60);
    $menit = $totalMenit % 60;

    return "{$jam} jam {$menit} menit";
}

public function requirement() {
    return $this->belongsTo(Requirement::class);
}
}
