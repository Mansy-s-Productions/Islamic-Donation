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
    public function singleSura($lang, $key ,$id){
        $TranslationsList = Http::accept('application/json')->get('https://quranenc.com/api/v1/translations/list')->collect();
        $SuraTranslation = Http::accept('application/json')->get('https://quranenc.com/api/v1/translation/sura/'.$key.'/'.$id)->collect();
        // dd($TranslationsList);
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
        // dd($SuraTranslation);
        foreach ($SuraTranslation['result'] as $key => $quran){
            if (in_array($quran['id'], $ImagesFiles)){
                array_push($FinalQuran, $quran);
            }
        }
        $FinalQuran = collect($FinalQuran)->paginate(100);
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
                return view('quran.single-sura', compact('ImagesFiles' ,'ArSura' ,'lang' ,'FinalQuran', 'arrays', 'TranslationsList'));
        }else{
            return view('quran.single-sura', compact('ImagesFiles' ,'ArSura' ,'lang' ,'FinalQuran', 'TranslationsList'));
        }
            // dd($AllSubmitted);
    }
    public function getAdminAll($lang = 'en', $suraKey){
        $AllSura = SuraList::all();
        $AllLanguages = Http::accept('application/json')->get('https://quranenc.com/api/v1/translations/list')->collect();
        return view('admin.quran.all', compact('AllSura', 'lang', 'AllLanguages', 'suraKey'));
    }
    public function getEditSura($lang, $id, $suraKey){
        // dd($lang);
        $AllLanguages = Http::accept('application/json')->get('https://quranenc.com/api/v1/translations/list')->collect();
        if($suraKey == 'arabic'){
        $TranslationsList = Http::accept('application/json')->get('https://quranenc.com/api/v1/translations/list')->collect();
            $ArSura = ArQuran::where([
                'ar_sura_number' => $id,
                ])->orderBy('aya_number', 'ASC')->get();
        return view('admin.quran.single', compact('suraKey' ,'TranslationsList' ,'AllLanguages' , 'ArSura', 'lang'));
        }
        $TheSura = Http::accept('application/json')->get('https://quranenc.com/api/v1/translation/sura/'.$suraKey.'/'.$id)->collect();
        $TranslationsList = Http::accept('application/json')->get('https://quranenc.com/api/v1/translations/list')->collect();
        $ArSura = ArQuran::where([
            'ar_sura_number' => $id,
            ])->orderBy('aya_number', 'ASC')->get();
            // dd($TheSura);
        return view('admin.quran.single', compact('TheSura' ,'suraKey' ,'TranslationsList' ,'AllLanguages' , 'ArSura', 'lang'));
    }
    public function getEditAya($lang ,$key, $suraId, $ayaId){
        $TheAya = Http::accept('application/json')->get('https://quranenc.com/api/v1/translation/aya/'.$key.'/'.$suraId.'/'.$ayaId)->collect();
        $TheAya = $TheAya['result'];
        return view('admin.quran.edit', compact('TheAya', 'lang'));
    }
    public function postEditAya(Request $r, $lang, $suraId, $ayaId){
        // $TheAya = Http::accept('application/json')->get('https://quranenc.com/api/v1/translation/aya/english_saheeh/'.$suraId.'/'.$ayaId)->collect();
        $Rules = [
            'aya_text' => 'required',
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
                $save_path = 'storage/app/public/quran/'.$lang;
                if (!file_exists($save_path)) {
                    File::makeDirectory($save_path, 0777, true, true);
                }
                $img->save('storage/app/public/quran/'.$lang.'/'.$ayaId.'.'.$r->image->getClientOriginalExtension());
                $Data['image'] = $ayaId.'.'.$r->image->getClientOriginalExtension();
            }
            // $TheAya->update($Data);
            return redirect()->back()->withSuccess("تم تعديل اﻵية بنجاح");
        }
    }
}
