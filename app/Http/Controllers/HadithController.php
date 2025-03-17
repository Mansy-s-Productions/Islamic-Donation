<?php

namespace App\Http\Controllers;

use App\Models\Hadith;
use App\Models\Language;
use App\Models\VolunteerPhotos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Image as ImageLib;
use Throwable;

class HadithController extends Controller
{
    const API_BASE_URL = 'https://hadeethenc.com/api/v1';
    const CACHE_DURATION = 60;

    public function getAdminAll($lang = 'en', $category_id = 1)
    {
        $hadithCacheKey = "hadith_{$lang}_{$category_id}";
        $categoriesCacheKey = "categories_{$lang}";
        $languagesCacheKey = 'languages';

        $AllHadith = Cache::remember($hadithCacheKey, self::CACHE_DURATION, function () use ($lang, $category_id) {
            $response = Http::accept('application/json')
                ->get(self::API_BASE_URL . '/hadeeths/list', [
                    'language' => $lang,
                    'category_id' => $category_id,
                    'per_page' => 1600,
                ]);
            return $response->collect()['data'];
        });

        $AllCategories = Cache::remember($categoriesCacheKey, self::CACHE_DURATION, function () use ($lang) {
            $response = Http::accept('application/json')
                ->get(self::API_BASE_URL . '/categories/roots', ['language' => $lang]);
            return $response->collect();
        });

        $AllArHadith = Http::accept('application/json')
            ->get(self::API_BASE_URL . '/hadeeths/list', [
                'language' => 'ar',
                'category_id' => $category_id,
                'per_page' => 3000,
            ]);

        $AllHadith = collect($AllHadith)->paginate(100);

        $AllLanguages = Cache::remember($languagesCacheKey, self::CACHE_DURATION, function () {
            $response = Http::accept('application/json')
                ->get(self::API_BASE_URL . '/languages');
            return $response->collect();
        });

        return view('admin.hadith.all', compact('AllHadith', 'AllArHadith', 'lang', 'AllLanguages', 'AllCategories', 'category_id'));
    }

    public function getAllCategories($lang = 'ar')
    {
        $AllCategories = Cache::remember("categories_{$lang}", self::CACHE_DURATION, function () use ($lang) {
            $response = Http::accept('application/json')
                ->get(self::API_BASE_URL . '/categories/roots', ['language' => $lang]);
            return $response->object();
        });

        return view('hadith.categories.all', compact('AllCategories', 'lang'));
    }

    public function getAllHadith($lang = 'ar', $category_id = 1)
    {
        try {
            $Images = File::files(storage_path('app/public/hadith/' . $lang));
            $ImagesFiles = array_map(function ($image) {
                return pathinfo($image, PATHINFO_FILENAME);
            }, $Images);
        } catch (Throwable $e) {
            report($e);
            $ImagesFiles = [];
        }

        $hadithCacheKey = "hadith_{$lang}_{$category_id}";
        $arHadithCacheKey = "hadith_ar_{$category_id}";

        $AllHadith = Cache::remember($hadithCacheKey, self::CACHE_DURATION, function () use ($lang, $category_id) {
            $response = Http::accept('application/json')
                ->get(self::API_BASE_URL . '/hadeeths/list', [
                    'language' => $lang,
                    'category_id' => $category_id,
                    'per_page' => 1600,
                ]);
            return $response->collect()['data'];
        });

        $AllArHadith = Cache::remember($arHadithCacheKey, self::CACHE_DURATION, function () use ($category_id) {
            $response = Http::accept('application/json')
                ->get(self::API_BASE_URL . '/hadeeths/list', [
                    'language' => 'ar',
                    'category_id' => $category_id,
                    'per_page' => 1600,
                ]);
            return $response->collect();
        });

        $FilteredHadith = array_filter($AllHadith, function ($hadith) use ($ImagesFiles, $lang) {
            return in_array($lang . '_' . $hadith['id'], $ImagesFiles);
        });

        $FinalHadith = collect($FilteredHadith)->paginate(100);

        $arrays = [];
        if (Auth::check()) {
            $userId = Auth::id();
            $arrays = VolunteerPhotos::where([
                'user_id' => $userId,
                'type' => 'hadith',
            ])->pluck('design_id')->toArray();
        }

        return view('hadith.all', compact('FinalHadith', 'arrays', 'lang', 'AllArHadith', 'ImagesFiles'));
    }

    public function getCreateHadith()
    {
        $AllLanguages = Cache::remember('languages', self::CACHE_DURATION, function () {
            $response = Http::accept('application/json')
                ->get(self::API_BASE_URL . '/languages');
            return $response->collect();
        });

        return view('admin.hadith.new', compact('AllLanguages'));
    }

    public function getEditHadith($id, $lang)
    {
        $TheHadith = Cache::remember("hadith_{$lang}_{$id}", self::CACHE_DURATION, function () use ($id, $lang) {
            $response = Http::accept('application/json')
                ->get(self::API_BASE_URL . '/hadeeths/one', [
                    'language' => $lang,
                    'id' => $id,
                ]);
            return $response->collect();
        });

        return view('admin.hadith.edit', compact('TheHadith', 'lang'));
    }

    public function postEditHadith(Request $r, $id, $lang)
    {
        $TheHadith = Http::accept('application/json')
            ->get(self::API_BASE_URL . '/hadeeths/one', [
                'language' => $lang,
                'id' => $id,
            ])->collect();

        $rules = [
            'image' => 'required|image|mimes:png,jpg,jpeg,webp',
        ];
        $validator = Validator::make($r->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors()->all());
        } else {
            if ($r->has('image')) {
                $imagePath = storage_path('app/public/hadith/' . $lang . '/' . $lang . '_' . $TheHadith['id'] . '.jpg');
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }

                $img = ImageLib::make($r->image);
                $savePath = storage_path('app/public/hadith/' . $lang);

                if (!File::exists($savePath)) {
                    File::makeDirectory($savePath, 0777, true, true);
                }

                $img->save($savePath . '/' . $lang . '_' . $TheHadith['id'] . '.jpg');
                Cache::flush();
            }
            return redirect()->route('admin.hadith.all', [$lang, 1])->withSuccess("تم تعديل التصميم بنجاح");
        }
    }
    public function getHadithImage($lang, $hadith_id)
    {
        // البحث عن الحديث في الكاش أو قاعدة البيانات
        $hadithData = Cache::remember("hadith_{$lang}_{$hadith_id}", self::CACHE_DURATION, function () use ($lang, $hadith_id) {
            return Hadith::where('lang_code', $lang)
                         ->where('hadith_id', $hadith_id)
                         ->first();
        });

        // التحقق مما إذا كان الحديث موجودًا
        if (!$hadithData) {
            return response()->json(['message' => 'الحديث غير موجود'], 404);
        }

        // جلب الصورة من قاعدة البيانات
        $imageFileName = $hadithData->image;
        $imageUrl = $imageFileName ? asset("storage/hadith/{$lang}/{$imageFileName}") : null;

        return response()->json([
            'hadith_id' => $hadithData->hadith_id,
            'text' => $hadithData->title, // نفترض أن `title` يحتوي على نص الحديث
            'grade' => $hadithData->grade, // درجة الحديث
            'link' => $hadithData->link, // رابط المصدر
            'image_url' => $imageUrl,
        ]);
    }
}
