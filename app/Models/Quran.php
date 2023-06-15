<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quran extends Model{
    use HasFactory;
    protected $guarded = [];
    public function getAyaImageAttribute(){
        return url('storage/app/public/en').'/'.$this->image;
    }
    public function SuraName(){
        return $this->belongsTo(SuraList::class, 'ar_sura_number');
    }
    // public function ArAya(){
    //     return $this->belongsTo(ArQuran::class, 'sura_number');
    // }
}
