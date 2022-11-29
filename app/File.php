<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{

    protected $fillable = [
        'name',
        'file_path',
        'category'
    ];
    public function user(){
        return $this->hasMany(User::class);
    }
}
