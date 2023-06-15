<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuraList extends Model{
    use HasFactory;
    public function ArAya(){
        return $this->hasMany(ArQuran::class, 'sura_number');
    }
}
