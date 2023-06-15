<?php

namespace App\Http\Controllers;

use App\Models\Hadith;
use App\Models\Language;
use App\Models\VolunteerPhotos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Image as ImageLib;


class HadithController extends Controller{
    public function getAdminAll($lang = 'ar'){
        $AllHadith = Hadith::all();
        $AllLanguages = Language::all();
        return view('admin.hadith.all', compact('AllHadith', 'lang', 'AllLanguages'));
    }
    public function getAllHadith($lang ='ar'){
        $AllHadith = Hadith::where('lang_code', $lang)->paginate(100);
        if(Auth::check()){
            $AllSubmitted = VolunteerPhotos::where([
                'user_id' => Auth::user()->id,
                'type' => 'hadith',
                ])->get();
                if(count($AllSubmitted)){
                    foreach($AllSubmitted as $key => $object){
                        $arrays[] = $object['design_id'];
                    }
                }else{
                    $arrays = [];
                }
            return view('hadith.all', compact('AllHadith','arrays', 'lang'));
        }else{
            return view('hadith.all', compact('AllHadith', 'lang'));
        }
    }

    public function getEditHadith($lang, $id){
        $TheHadith = Hadith::findOrFail($id);
        if(!$TheHadith){
            return redirect()->route('admin.hadith.all')->withErrors("لم يتم العثور على الحديث بهذه اللغة");
        }
        return view('admin.hadith.edit', compact('TheHadith', 'lang'));
    }
    public function postEditHadith(Request $r, $lang, $id){
        $TheHadith = Hadith::findOrFail($id);
        $Rules = [
            'image' =>'required|image|mimes:png,jpg,jpeg,webp',
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
                $img->save('storage/app/public/hadith/'.$lang.'/'.$TimeNow.'.'.$r->image->getClientOriginalExtension());
                $Data['image'] = $TimeNow.'.'.$r->image->getClientOriginalExtension();
            }
            $TheHadith->update($Data);
            return redirect()->route('admin.hadith.all')->withSuccess("تم تعديل التصميم بنجاح");
        }
    }

    // public function changeName(){
    //     $AllHadith = Hadith::all();
    //     foreach($AllHadith as $key => $Hadith){
    //         //Generate the name
    //         $name = $Hadith->hadith_id;

    //         $FileArray['image'] = $name.'.jpg';
    //         // dd($FileArray);
    //         $Hadith->update($FileArray);
    //     }
    //     return redirect()->route('home');
    // }
}
