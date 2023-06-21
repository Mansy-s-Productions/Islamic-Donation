<?php

namespace App\Http\Controllers;

use App\Models\ArQuran;
use App\Models\Language;
use App\Models\Quran;
use App\Models\SuraList;
use App\Models\VolunteerPhotos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Image as ImageLib;


class QuranController extends Controller{
    public function getAllQuran(){
        $AllSuras = SuraList::all();
        return view('quran.all', compact('AllSuras'));
    }
    public function singleSura($lang ,$id){
        $TheSura = SuraList::findOrFail($id);
        // dd($TheSura);
        $AllAya = Quran::where([
            'sura_id' => $TheSura->id,
            'lang_code' => $lang,
        ])->get();
        $AllArAya = ArQuran::where([
            'ar_sura_number' => $TheSura->id,
        ])->get();
        if(Auth::check()){
            $AllSubmitted = VolunteerPhotos::where([
                'user_id' => Auth::user()->id,
                ])->get();
                if(count($AllSubmitted)){
                    foreach($AllSubmitted as $key => $object){
                        $arrays[] = $object['design_id'];
                    }
                }else{
                    $arrays = [];
                }
            return view('quran.single-sura', compact('AllAya', 'AllArAya' ,'arrays'));
        }else{
            return view('quran.single-sura', compact('AllAya', 'AllArAya'));

        }
            // dd($AllSubmitted);
    }
    public function getAdminAll($lang = 'en'){
        $AllSura = SuraList::all();
        $AllLanguages = Language::all();
        return view('admin.quran.all', compact('AllSura', 'lang', 'AllLanguages'));
    }
    public function getEditSura($lang, $id){
        $TheSura = Quran::where([
            'lang_code' => $lang,
            'sura_id' => $id,
        ])->orderBy('aya_number', 'ASC')->get();
        $ArSura = ArQuran::where([
            'ar_sura_number' => $id,
        ])->orderBy('aya_number', 'ASC')->get();
        if($TheSura->isEmpty() || $TheSura->isEmpty()){
            return redirect()->route('admin.quran.all')->withErrors("لم يتم العثور على سورة بهذه اللغة");
        }
        return view('admin.quran.single', compact('TheSura' ,'ArSura' , 'lang'));
    }
    public function getEditAya($lang, $id){
        $TheAya = Quran::findOrFail($id);
        return view('admin.quran.edit', compact('TheAya', 'lang'));
    }
    public function postEditAya(Request $r, $lang, $id){
        $TheAya = Quran::findOrFail($id);
        $Rules = [
            'aya_text' => 'required',
            'image' =>'image|mimes:png,jpg,jpeg,webp',
        ];
        $Validator = Validator::make($r->all(), $Rules);
        if($Validator->fails()){
            return back()->withErrors($Validator->errors()->all());
        }else{
            $Data = $r->all();
            $TimeNow = Carbon::now()->timestamp;
            if($r->has('image')){
                //Resize the image file & upload it (250x250) (60x60) (650x650)
                $img = ImageLib::make($r->image);
                $img->save('storage/app/public/'.$lang.'/'.$TimeNow.'.'.$r->image->getClientOriginalExtension());
                $Data['image'] = $TimeNow.'.'.$r->image->getClientOriginalExtension();
            }
            $TheAya->update($Data);
            return redirect()->route('admin.quran.all')->withSuccess("تم تعديل اﻵية بنجاح");
        }
    }
}
