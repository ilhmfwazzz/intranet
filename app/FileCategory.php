<?php

namespace App;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileCategory extends Model
{

    protected $fillable = [
        'id_file_category',
        'category'
    ];

    public function FileCategory(){
        $this->belongsTo('files','category');
    }
}
