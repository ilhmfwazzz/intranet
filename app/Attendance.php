<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'id', 'user_id', 'category', 'note', 'entry_date', 'tanggal', 'waktu'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
