<?php

namespace App\Http\Controllers;

use App\Models\Quran;

class SuraListController extends Controller
{
    public function changeName()
    {
        $AllAya = Quran::all();
        foreach ($AllAya as $key => $Aya) {
            // Generate the name
            $FirstId = $Aya->sura_number;
            $SecondId = $Aya->aya_number;

            $FileArray['image'] = $FirstId.'-'.$SecondId.'.jpg';
            // dd($FileArray);
            $Aya->update($FileArray);
        }

        return redirect()->route('home');
    }
}
