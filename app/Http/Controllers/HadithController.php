<?php

namespace App\Http\Controllers;

use App\Models\Hadith;
use App\Models\Language;
use App\Models\VolunteerPhotos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Image as ImageLib;
use Illuminate\Support\Facades\Http;


class HadithController extends Controller{
    public function getAdminAll($category_id = 1, $lang = 'en'){
        $AllHadith = Http::accept('application/json')->get('https://hadeethenc.com/api/v1/hadeeths/list/?language='.$lang.'&category_id='.$category_id.'&per_page=1600');
        $AllArHadith = Http::accept('application/json')->get('https://hadeethenc.com/api/v1/hadeeths/list/?language=ar'.'&category_id='.$category_id.'&per_page=1600');
        $AllHadith = $AllHadith['data'];
        $AllHadith = collect($AllHadith)->paginate(100);
        $AllLanguages = Language::all();
        return view('admin.hadith.all', compact('AllHadith', 'AllArHadith', 'lang', 'AllLanguages'));
    }
    public function getAllCategories($lang ='ar'){
        $AllCategories = Http::accept('application/json')->get('https://hadeethenc.com/api/v1/categories/roots/?language='.$lang);
        $AllCategories = $AllCategories->object();
        // dd($AllCategories);
        return view('hadith.categories.all', compact('AllCategories', 'lang'));
    }
    public function getAllHadith($lang = 'ar', $category_id = 1){
        $Images = File::files('storage/app/public/hadith/'.$lang);
        $ImagesFiles = [];
        $string = ".jpg";
        foreach($Images as $key => $Image) {
            $NewImage = trim(basename($Image), $string);
            array_push($ImagesFiles, $NewImage);
        }
        $AllHadith = Http::accept('application/json')->get('https://hadeethenc.com/api/v1/hadeeths/list/?language='.$lang.'&category_id='.$category_id.'&per_page=1600')['data'];
        $AllArHadith = Http::accept('application/json')->get('https://hadeethenc.com/api/v1/hadeeths/list/?language=ar'.'&category_id='.$category_id.'&per_page=1600');
        $AllHadith = collect($AllHadith)->paginate(100);
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
            return view('hadith.all', compact('AllHadith','arrays', 'lang', 'AllArHadith', 'ImagesFiles'));
        }else{
            return view('hadith.all', compact('AllHadith', 'lang', 'AllArHadith', 'ImagesFiles'));
        }
    }
    public function getCreateHadith(){
        $AllLanguages = Language::all();
        return view('admin.hadith.new', compact('AllLanguages'));
    }
    public function postCreateHadith(Request $r){
        $Rules = [
            'hadith_id' => 'required|numeric',
            'title' =>'required',
            'lang_code' =>'required',
            'image' =>'required|image|mimes:png,jpg,jpeg,webp',
        ];
        $Validator = Validator::make($r->all(), $Rules);
        if($Validator->fails()){
            return back()->withErrors($Validator->errors()->all());
        }else{
            $Data = $r->all();
            $lang = $Data['lang_code'];
            // dd($Data);
            $TimeNow = Carbon::now()->timestamp;
            if($r->has('image')){
                //Resize the image file & upload it (250x250) (60x60) (650x650)
                $img = ImageLib::make($r->image);
                $img->save('storage/app/public/hadith/'.$lang.'/'.$TimeNow.'.'.$r->image->getClientOriginalExtension());
                $Data['image'] = $TimeNow.'.'.$r->image->getClientOriginalExtension();
            }
            Hadith::Create($Data);
            return redirect()->route('admin.hadith.all')->withSuccess("تم إضافة الحديث بنجاح");
        }
    }
    public function getEditHadith($id , $lang){
        $TheHadith = Http::accept('application/json')->get('https://hadeethenc.com/api/v1/hadeeths/one/?language='.$lang.'&id='.$id);
        $TheHadith = $TheHadith->collect();
        // dd($TheHadith);
        return view('admin.hadith.edit', compact('TheHadith', 'lang'));
    }
    public function postEditHadith(Request $r, $id){
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
            $lang = $TheHadith->lang_code;
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
    public function deleteHadith($id){
        $TheHadith = Hadith::findOrFail($id);
        $lang = $TheHadith->lang_code;
        if($TheHadith->image){
            // dd('app/public/hadith/'.$lang.'/'.$TheHadith->image);
            Storage::disk('local')->delete('storage/app/public/hadith/'.$lang.'/'.$TheHadith->image);
        }
        $TheHadith->delete();
        return redirect()->route('admin.hadith.all')->withSuccess("تم مسح الحديث بنجاح");
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
