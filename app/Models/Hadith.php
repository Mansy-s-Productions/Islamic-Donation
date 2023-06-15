<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Hadith extends Model{
    use HasFactory;
    const LIMIT = 100;
    protected $guarded = [];

    public function getHadithOriginalTextattribute(){
        return Str::limit($this->title, Hadith::LIMIT);
    }
    public function getHadithImageAttribute($lang = 'ar'){
        return url('storage/app/public/hadith/').'/'.$lang.'/'.$this->image;
    }
}
