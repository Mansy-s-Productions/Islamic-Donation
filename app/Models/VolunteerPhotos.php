<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nette\Utils\Arrays;

class VolunteerPhotos extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function User(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function Quran(){
        return $this->belongsTo(ArQuran::class, 'sura_id');
    }
    public function getSuraNameAttribute(){
        if($this->type == 'quran'){
            return 'قرآن';
        }else{
            return 'حديث';
        }
    }
}

