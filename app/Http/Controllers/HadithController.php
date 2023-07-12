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
use Throwable;

class HadithController extends Controller{
    public function getAdminAll($lang = 'en', $category_id = 1){
        $AllHadith = Http::accept('application/json')->get('https://hadeethenc.com/api/v1/hadeeths/list/?language='.$lang.'&category_id='.$category_id.'&per_page=1600')->collect();
        $AllCategories = Http::accept('application/json')->get('https://hadeethenc.com/api/v1/categories/roots/?language='.$lang)->collect();
        // dd($AllCategories);
        $AllArHadith = Http::accept('application/json')->get('https://hadeethenc.com/api/v1/hadeeths/list/?language=ar'.'&category_id='.$category_id.'&per_page=3000');
        $AllHadith = $AllHadith['data'];
        $AllHadith = collect($AllHadith)->paginate(100);
        $AllLanguages = Http::accept('application/json')->get('https://hadeethenc.com/api/v1/languages')->collect();
        return view('admin.hadith.all', compact('AllHadith', 'AllArHadith', 'lang', 'AllLanguages', 'AllCategories', 'category_id'));
    }
    public function getAllCategories($lang ='ar'){
        $AllCategories = Http::accept('application/json')->get('https://hadeethenc.com/api/v1/categories/roots/?language='.$lang);
        $AllCategories = $AllCategories->object();
        return view('hadith.categories.all', compact('AllCategories', 'lang'));
    }
    public function getAllHadith($lang = 'ar', $category_id = 1){
        try {
            $Images = File::files('storage/app/public/hadith/'.$lang);
            $ImagesFiles = [];
            $string = ".jpg";
            foreach($Images as $key => $Image) {
                $NewImage = trim(basename($Image), $string);
                array_push($ImagesFiles, $NewImage);
            }
            // Validate the value...
        } catch (Throwable $e) {
            report($e);
        }
        $AllHadith = Http::accept('application/json')->get('https://hadeethenc.com/api/v1/hadeeths/list/?language='.$lang.'&category_id='.$category_id.'&per_page=1600')['data'];
        $AllArHadith = Http::accept('application/json')->get('https://hadeethenc.com/api/v1/hadeeths/list/?language=ar'.'&category_id='.$category_id.'&per_page=1600');
        $AllHadith = collect($AllHadith)->paginate(100);
        $FinalHadith =[];
        foreach ($AllHadith as $key => $hadith){
            if (in_array($lang.'_'.$hadith['id'], $ImagesFiles)){
                array_push($FinalHadith, $hadith);
            }
        }
        $FinalHadith = collect($FinalHadith)->paginate(100);
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
            return view('hadith.all', compact('FinalHadith','arrays', 'lang', 'AllArHadith', 'ImagesFiles'));
        }else{
            return view('hadith.all', compact('FinalHadith', 'lang', 'AllArHadith', 'ImagesFiles'));
        }
    }
    public function getCreateHadith(){
        $AllLanguages = Http::accept('application/json')->get('https://hadeethenc.com/api/v1/languages')->collect();
        return view('admin.hadith.new', compact('AllLanguages'));
    }
    public function getEditHadith($id , $lang){
        $TheHadith = Http::accept('application/json')->get('https://hadeethenc.com/api/v1/hadeeths/one/?language='.$lang.'&id='.$id);
        $TheHadith = $TheHadith->collect();
        return view('admin.hadith.edit', compact('TheHadith', 'lang'));
    }
    public function postEditHadith(Request $r, $id, $lang){
        $TheHadith = Http::accept('application/json')->get('https://hadeethenc.com/api/v1/hadeeths/one/?language='.$lang.'&id='.$id)->collect();
        $Rules = [
            'image' =>'required|image|mimes:png,jpg,jpeg,webp',
        ];
        $Validator = Validator::make($r->all(), $Rules);
        if($Validator->fails()){
            return back()->withErrors($Validator->errors()->all());
        }else{
            $Data = $r->all();
            if($r->has('image')){
                //Resize the image file & upload it (250x250) (60x60) (650x650)
                $img = ImageLib::make($r->image);
                $save_path = 'storage/app/public/hadith/'.$lang;
                if (!file_exists($save_path)) {
                    File::makeDirectory($save_path, 0777, true, true);
                }
                $img->save('storage/app/public/hadith/'.$lang.'/'.$lang.'_'.$TheHadith['id'].'.'.$r->image->getClientOriginalExtension());
                $Data['image'] = $lang.'_'.$TheHadith['id'].'.'.$r->image->getClientOriginalExtension();
            }
            return redirect()->route('admin.hadith.all', [$lang, 1])->withSuccess("تم تعديل التصميم بنجاح");
        }
    }
}
