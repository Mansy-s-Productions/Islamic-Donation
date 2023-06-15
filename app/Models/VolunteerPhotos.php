<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VolunteerPhotos extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function User(){
        return $this->hasMany(User::class, 'user_id');
    }
}

