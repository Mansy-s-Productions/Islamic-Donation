<?php

namespace App\Http\Controllers;

use App\Models\ArQuran;
use App\Models\Quran;
use App\Models\SuraList;
use App\Models\VolunteerPhotos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuraListController extends Controller{


    public function changeName(){
        $AllAya = Quran::all();
        foreach($AllAya as $key => $Aya){
            //Generate the name
            $FirstId = $Aya->sura_number;
            $SecondId = $Aya->aya_number;

            $FileArray['image'] = $FirstId . '-' . $SecondId.'.jpg';
            // dd($FileArray);
            $Aya->update($FileArray);
        }
        return redirect()->route('home');
    }
}
