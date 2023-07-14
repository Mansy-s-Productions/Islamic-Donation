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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Image as ImageLib;
use Throwable;

class QuranController extends Controller{
    public function getAllQuran(){
        $AllSuras = SuraList::all();
        return view('quran.all', compact('AllSuras'));
    }
    public function singleSura($lang ,$id){
        $Availableanguages = Http::accept('application/json')->get('https://quranenc.com/api/v1/translations/languages')->collect('languages');
        $LanguagesList = Http::accept('application/json')->get('https://quranenc.com/api/v1/translations/isocodes')->collect('isocodes_languages');
        if($lang == 'ar'){
            $SuraTranslation = ArQuran::where([
                'ar_sura_number' => $id,
                ])->orderBy('aya_number', 'ASC')->get();
                try {
                    $ImagesFiles = [];
                    $Images = File::files('storage/app/public/quran/'.$lang);
                    $string = ".jpg";
                    foreach($Images as $key => $Image) {
                        $NewImage = trim(basename($Image), $string);
                        array_push($ImagesFiles, $NewImage);
                    }
                    // Validate the value...
                } catch (Throwable $e) {
                    report($e);
                }
                $FinalQuran =[];
                foreach ($SuraTranslation as $key => $quran){
                    if (in_array($lang.'_'.$quran->ar_sura_number.'_'.$quran->aya_number, $ImagesFiles)){
                        array_push($FinalQuran, $quran);
                    }
                }
                $FinalQuran = collect($FinalQuran);
                $ArSura = ArQuran::where([
                    'ar_sura_number' => $id,
                    ])->get();
            if(Auth::check()){
                $AllSubmitted = VolunteerPhotos::where([
                    'user_id' => Auth::user()->id,
                    'lang' => $lang,
                    'type' => 'quran',
                    ])->get();
                    if(count($AllSubmitted)){
                        foreach($AllSubmitted as $key => $object){
                            $arrays[] = $object['design_id'];
                        }
                    }else{
                        $arrays = [];
                    }
                    return view('quran.single-sura', compact('FinalQuran','ImagesFiles', 'Availableanguages','LanguagesList', 'SuraTranslation' ,'ArSura' ,'lang' , 'arrays'));
            }else{
                return view('quran.single-sura', compact('FinalQuran','ImagesFiles', 'Availableanguages','LanguagesList', 'SuraTranslation' ,'ArSura' ,'lang' ));
            }
            }
            $SuraLanguage = Http::accept('application/json')->get('https://quranenc.com/api/v1/translations/list/'.$lang)->collect('translations')[0];
            $SuraTranslation = Http::accept('application/json')->get('https://quranenc.com/api/v1/translation/sura/'.$SuraLanguage['key'].'/'.$id)->collect('result');
        try {
            $ImagesFiles = [];
            $Images = File::files('storage/app/public/quran/'.$lang);
            $string = ".jpg";
            foreach($Images as $key => $Image) {
                $NewImage = trim(basename($Image), $string);
                array_push($ImagesFiles, $NewImage);
            }
            // Validate the value...
        } catch (Throwable $e) {
            report($e);
        }
        $FinalQuran =[];
        foreach ($SuraTranslation as $key => $quran){
            if (in_array($lang.'_'.$quran['sura'].'_'.$quran['aya'], $ImagesFiles)){
                array_push($FinalQuran, $quran);
            }
        }
        $FinalQuran = collect($FinalQuran);
            $ArSura = ArQuran::where([
                'ar_sura_number' => $id,
                ])->get();
        if(Auth::check()){
            $AllSubmitted = VolunteerPhotos::where([
                'user_id' => Auth::user()->id,
                'lang' => $lang,
                'type' => 'quran',
                ])->get();
                if(count($AllSubmitted)){
                    foreach($AllSubmitted as $key => $object){
                        $arrays[] = $object['design_id'];
                    }
                }else{
                    $arrays = [];
                }
                return view('quran.single-sura', compact('FinalQuran','ImagesFiles','Availableanguages','LanguagesList', 'SuraTranslation' ,'ArSura' ,'lang' , 'arrays'));
        }else{
            return view('quran.single-sura', compact('FinalQuran','ImagesFiles','Availableanguages','LanguagesList', 'SuraTranslation' ,'ArSura' ,'lang' ));
        }
    }
    public function getAdminAll($lang = 'en'){
        $AllSura = SuraList::all();
        $Availableanguages = Http::accept('application/json')->get('https://quranenc.com/api/v1/translations/languages')->collect('languages');
        $AllLanguages = Http::accept('application/json')->get('https://quranenc.com/api/v1/translations/isocodes')->collect('isocodes_languages');
        return view('admin.quran.all', compact('AllSura', 'lang', 'AllLanguages', 'Availableanguages'));
    }
    public function getEditSura($lang, $id){
        $Availableanguages = Http::accept('application/json')->get('https://quranenc.com/api/v1/translations/languages')->collect('languages');
        $AllLanguages = Http::accept('application/json')->get('https://quranenc.com/api/v1/translations/isocodes')->collect('isocodes_languages');
        if($lang == 'ar'){
            $ArSura = ArQuran::where([
                'ar_sura_number' => $id,
                ])->orderBy('aya_number', 'ASC')->get();
            return view('admin.quran.single', compact('AllLanguages', 'Availableanguages', 'ArSura', 'lang'));
        }
        $SuraTranslation = Http::accept('application/json')->get('https://quranenc.com/api/v1/translations/list/'.$lang)->collect('translations')[0];
        $TheSura = Http::accept('application/json')->get('https://quranenc.com/api/v1/translation/sura/'.$SuraTranslation['key'].'/'.$id)->collect('result');
        $TranslationsList = Http::accept('application/json')->get('https://quranenc.com/api/v1/translations/list')->collect();
        $ArSura = ArQuran::where([
            'ar_sura_number' => $id,
            ])->orderBy('aya_number', 'ASC')->get();
        return view('admin.quran.single', compact('TheSura' ,'TranslationsList' ,'AllLanguages','Availableanguages' ,'ArSura' ,'lang'));
    }
    public function getEditAya($lang ,$suraId ,$ayaId){
        if($lang == 'ar'){
        $TheAya = ArQuran::where([
            'ar_sura_number' => $suraId,
            'aya_number' => $ayaId,
            ])->orderBy('aya_number', 'ASC')->first();
            return view('admin.quran.edit', compact('TheAya', 'lang'));
        }
        $SuraTranslation = Http::accept('application/json')->get('https://quranenc.com/api/v1/translations/list/'.$lang)->collect('translations')[0];
        $TheAya = Http::accept('application/json')->get('https://quranenc.com/api/v1/translation/aya/'.$SuraTranslation['key'].'/'.$suraId.'/'.$ayaId)->collect('result');
        return view('admin.quran.edit', compact('TheAya', 'lang'));
    }
    public function postEditAya(Request $r, $lang, $suraId, $ayaId){
        $Rules = [
            'image' =>'image|mimes:png,jpg,jpeg,webp',
        ];
        $Validator = Validator::make($r->all(), $Rules);
        if($Validator->fails()){
            return back()->withErrors($Validator->errors()->all());
        }else{
            $Data = $r->all();
            if($r->has('image')){
                //Resize the image file & upload it (250x250) (60x60) (650x650)
                $img = ImageLib::make($r->image);
                $image_path = public_path('storage/app/public/quran/'.$lang.'/'.$lang.'_'.$suraId.'_'.$ayaId.'.jpg');
                if(File::exists($image_path)) {
                    File::delete($image_path);
                }
                $save_path = 'storage/app/public/quran/'.$lang;
                if (!file_exists($save_path)) {
                    File::makeDirectory($save_path, 0777, true, true);
                }
                $img->save('storage/app/public/quran/'.$lang.'/'.$lang.'_'.$suraId.'_'.$ayaId.'.jpg');
                Cache::flush();
            }
            return redirect()->back()->withSuccess("تم تعديل اﻵية بنجاح");
        }
    }
}
