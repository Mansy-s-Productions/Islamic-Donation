<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ArQuran extends Model{
    use HasFactory;
    const LIMIT = 150;

    // public function Aya(){
    //     return $this->belongsTo(Quran::class, 'aya_number');
    // }
    public function getAyaOriginalTextattribute(){
        return Str::limit($this->aya_text, ArQuran::LIMIT);
    }
}
