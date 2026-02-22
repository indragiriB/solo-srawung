<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = ['volunteer_id', 'requirement_id', 'file_cv', 'status'];

    // TAMBAHKAN RELASI INI:
    public function requirement()
    {
        return $this->belongsTo(Requirement::class);
    }

    public function volunteer()
    {
        return $this->belongsTo(User::class, 'volunteer_id');
    }
}