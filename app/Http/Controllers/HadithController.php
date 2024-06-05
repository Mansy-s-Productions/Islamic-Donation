<?php

namespace App\Http\Controllers;

use App\Models\Hadith;
use App\Models\Language;
use App\Models\VolunteerPhotos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Image as ImageLib;
use Illuminate\Support\Facades\Http;
use Throwable;

class HadithController extends Controller{
    public function getAdminAll($lang = 'en', $category_id = 1){
           // Base API URL
            $apiBaseUrl = 'https://hadeethenc.com/api/v1';

            // Cache keys
            $hadithCacheKey = "hadith_{$lang}_{$category_id}";
            $categoriesCacheKey = "categories_{$lang}";
            $languagesCacheKey = 'languages';
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
    public function getAllHadith($lang = 'ar', $category_id = 1)
    {
        try {
            // Fetch images and process filenames
            $Images = File::files(storage_path('app/public/hadith/'.$lang));
            $ImagesFiles = array_map(function($image) {
                return pathinfo($image, PATHINFO_FILENAME);
            }, $Images);

        } catch (Throwable $e) {
            report($e);
            $ImagesFiles = [];
        }

        // Base API URL
        $apiBaseUrl = 'https://hadeethenc.com/api/v1';

        // Cache keys
        $hadithCacheKey = "hadith_{$lang}_{$category_id}";
        $arHadithCacheKey = "hadith_ar_{$category_id}";

        // Fetch Hadiths with caching
        $AllHadith = Cache::remember($hadithCacheKey, 60, function() use ($apiBaseUrl, $lang, $category_id) {
            $response = Http::accept('application/json')
                            ->get("$apiBaseUrl/hadeeths/list", [
                                'language' => $lang,
                                'category_id' => $category_id,
                                'per_page' => 1600
                            ]);
            return $response->collect()['data'];
        });

        $AllArHadith = Cache::remember($arHadithCacheKey, 60, function() use ($apiBaseUrl, $category_id) {
            $response = Http::accept('application/json')
                            ->get("$apiBaseUrl/hadeeths/list", [
                                'language' => 'ar',
                                'category_id' => $category_id,
                                'per_page' => 1600
                            ]);
            return $response->collect();
        });

        // Filter Hadiths with images
        $FilteredHadith = array_filter($AllHadith, function($hadith) use ($ImagesFiles, $lang) {
            return in_array($lang.'_'.$hadith['id'], $ImagesFiles);
        });

        $FinalHadith = collect($FilteredHadith)->paginate(100);

        // Handle authenticated user
        $arrays = [];
        if (Auth::check()) {
            $userId = Auth::id();
            $AllSubmitted = VolunteerPhotos::where([
                'user_id' => $userId,
                'type' => 'hadith',
            ])->pluck('design_id')->toArray();

            $arrays = !empty($AllSubmitted) ? $AllSubmitted : [];
        }

        return view('hadith.all', compact('FinalHadith', 'arrays', 'lang', 'AllArHadith', 'ImagesFiles'));
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
                // Find Image and delete it first
                $image_path = public_path('storage/app/public/hadith/'.$lang.'/'.$lang.'_'.$TheHadith['id'].'.jpg');
                if(File::exists($image_path)) {
                    File::delete($image_path);
                }
                $img = ImageLib::make($r->image);
                $save_path = 'storage/app/public/hadith/'.$lang;
                if (!file_exists($save_path)) {
                    File::makeDirectory($save_path, 0777, true, true);
                }
                $img->save('storage/app/public/hadith/'.$lang.'/'.$lang.'_'.$TheHadith['id'].'.jpg');
                Cache::flush();
            }
            return redirect()->route('admin.hadith.all', [$lang, 1])->withSuccess("تم تعديل التصميم بنجاح");
        }
    }
}
