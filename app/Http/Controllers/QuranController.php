<?php

namespace App\Http\Controllers;

use App\Models\ArQuran;
use App\Models\SuraList;
use App\Models\VolunteerPhotos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Image as ImageLib;
use Throwable;

class QuranController extends Controller
{
    const API_BASE_URL = 'https://quranenc.com/api/v1';

    const CACHE_DURATION = 60;

    public function getAllQuran()
    {
        $AllSuras = SuraList::all();

        return view('quran.all', compact('AllSuras'));
    }

    public function singleSura($lang, $id)
    {
        $AvailableLanguages = Cache::remember('available_languages', self::CACHE_DURATION, function () {
            return Http::accept('application/json')->get(self::API_BASE_URL.'/translations/languages')->collect('languages');
        });

        $LanguagesList = Cache::remember('languages_list', self::CACHE_DURATION, function () {
            return Http::accept('application/json')->get(self::API_BASE_URL.'/translations/isocodes')->collect('isocodes_languages');
        });

        if ($lang == 'ar') {
            $SuraTranslation = ArQuran::where('ar_sura_number', $id)->orderBy('aya_number', 'ASC')->get();
            $ImagesFiles = $this->getImagesFiles($lang);
            $FinalQuran = $this->filterQuranWithImages($SuraTranslation, $ImagesFiles, $lang);
            $ArSura = ArQuran::where('ar_sura_number', $id)->get();

            $arrays = $this->getSubmittedDesigns($lang, 'quran');

            return view('quran.single-sura', compact('FinalQuran', 'ImagesFiles', 'AvailableLanguages', 'LanguagesList', 'SuraTranslation', 'ArSura', 'lang', 'arrays'));
        }

        $SuraLanguage = Cache::remember("sura_language_{$lang}", self::CACHE_DURATION, function () use ($lang) {
            return Http::accept('application/json')->get(self::API_BASE_URL."/translations/list/{$lang}")->collect('translations')[0];
        });

        $SuraTranslation = Cache::remember("sura_translation_{$lang}_{$id}", self::CACHE_DURATION, function () use ($SuraLanguage, $id) {
            return Http::accept('application/json')->get(self::API_BASE_URL."/translation/sura/{$SuraLanguage['key']}/{$id}")->collect('result');
        });

        $ImagesFiles = $this->getImagesFiles($lang);
        $FinalQuran = $this->filterQuranWithImages($SuraTranslation, $ImagesFiles, $lang, 'sura', 'aya');
        $ArSura = ArQuran::where('ar_sura_number', $id)->get();

        $arrays = $this->getSubmittedDesigns($lang, 'quran');

        return view('quran.single-sura', compact('FinalQuran', 'ImagesFiles', 'AvailableLanguages', 'LanguagesList', 'SuraTranslation', 'ArSura', 'lang', 'arrays'));
    }

    public function getAdminAll($lang = 'en')
    {
        $AllSura = SuraList::all();
        $AvailableLanguages = Cache::remember('available_languages', self::CACHE_DURATION, function () {
            return Http::accept('application/json')->get(self::API_BASE_URL.'/translations/languages')->collect('languages');
        });

        $AllLanguages = Cache::remember('languages_list', self::CACHE_DURATION, function () {
            return Http::accept('application/json')->get(self::API_BASE_URL.'/translations/isocodes')->collect('isocodes_languages');
        });

        return view('admin.quran.all', compact('AllSura', 'lang', 'AllLanguages', 'AvailableLanguages'));
    }

    public function getEditSura($lang, $id)
    {
        $AvailableLanguages = Cache::remember('available_languages', self::CACHE_DURATION, function () {
            return Http::accept('application/json')->get(self::API_BASE_URL.'/translations/languages')->collect('languages');
        });

        $AllLanguages = Cache::remember('languages_list', self::CACHE_DURATION, function () {
            return Http::accept('application/json')->get(self::API_BASE_URL.'/translations/isocodes')->collect('isocodes_languages');
        });

        if ($lang == 'ar') {
            $ArSura = ArQuran::where('ar_sura_number', $id)->orderBy('aya_number', 'ASC')->get();

            return view('admin.quran.single', compact('AllLanguages', 'AvailableLanguages', 'ArSura', 'lang'));
        }

        $SuraTranslation = Cache::remember("sura_translation_{$lang}_list", self::CACHE_DURATION, function () use ($lang) {
            return Http::accept('application/json')->get(self::API_BASE_URL."/translations/list/{$lang}")->collect('translations')[0];
        });

        $TheSura = Cache::remember("the_sura_{$lang}_{$id}", self::CACHE_DURATION, function () use ($SuraTranslation, $id) {
            return Http::accept('application/json')->get(self::API_BASE_URL."/translation/sura/{$SuraTranslation['key']}/{$id}")->collect('result');
        });

        $TranslationsList = Cache::remember('translations_list', self::CACHE_DURATION, function () {
            return Http::accept('application/json')->get(self::API_BASE_URL.'/translations/list')->collect();
        });

        $ArSura = ArQuran::where('ar_sura_number', $id)->orderBy('aya_number', 'ASC')->get();

        return view('admin.quran.single', compact('TheSura', 'TranslationsList', 'AllLanguages', 'AvailableLanguages', 'ArSura', 'lang'));
    }

    public function getEditAya($lang, $suraId, $ayaId)
    {
        if ($lang == 'ar') {
            $TheAya = ArQuran::where([
                'ar_sura_number' => $suraId,
                'aya_number' => $ayaId,
            ])->orderBy('aya_number', 'ASC')->first();

            return view('admin.quran.edit', compact('TheAya', 'lang'));
        }

        $SuraTranslation = Cache::remember("sura_translation_{$lang}_list", self::CACHE_DURATION, function () use ($lang) {
            return Http::accept('application/json')->get(self::API_BASE_URL."/translations/list/{$lang}")->collect('translations')[0];
        });

        $TheAya = Cache::remember("the_aya_{$lang}_{$suraId}_{$ayaId}", self::CACHE_DURATION, function () use ($SuraTranslation, $suraId, $ayaId) {
            return Http::accept('application/json')->get(self::API_BASE_URL."/translation/aya/{$SuraTranslation['key']}/{$suraId}/{$ayaId}")->collect('result');
        });

        return view('admin.quran.edit', compact('TheAya', 'lang'));
    }

    public function postEditAya(Request $r, $lang, $suraId, $ayaId)
    {
        $rules = [
            'image' => 'image|mimes:png,jpg,jpeg,webp',
        ];
        $validator = Validator::make($r->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors()->all());
        } else {
            if ($r->has('image')) {
                $this->saveImage($r->image, $lang, $suraId, $ayaId);
                Cache::flush();
            }

            return redirect()->route('admin.quran.all', 'en')->withSuccess('تم تعديل اﻵية بنجاح');
        }
    }

    public function getIslamicLinks()
    {
        return view('islamic-links');
    }

    private function getImagesFiles($lang)
    {
        try {
            $images = File::files(storage_path('app/public/quran/'.$lang));

            return array_map(function ($image) {
                return trim(basename($image), '.jpg');
            }, $images);
        } catch (Throwable $e) {
            report($e);

            return [];
        }
    }

    private function filterQuranWithImages($quranList, $imagesFiles, $lang, $suraKey = 'ar_sura_number', $ayaKey = 'aya_number')
    {
        return collect(array_filter(
            $quranList->toArray(),
            function ($quran) use ($imagesFiles, $lang, $suraKey, $ayaKey) {
                return in_array("{$lang}_{$quran[$suraKey]}_{$quran[$ayaKey]}", $imagesFiles);
            }
        ));
    }

    private function getSubmittedDesigns($lang, $type)
    {
        if (Auth::check()) {
            $userId = Auth::id();

            return VolunteerPhotos::where([
                'user_id' => $userId,
                'lang' => $lang,
                'type' => $type,
            ])->pluck('design_id')->toArray();
        }

        return [];
    }

    private function saveImage($image, $lang, $suraId, $ayaId)
    {
        $img = ImageLib::make($image);
        $imagePath = storage_path("app/public/quran/{$lang}/{$lang}_{$suraId}_{$ayaId}.jpg");

        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        $savePath = storage_path("app/public/quran/{$lang}");
        if (! file_exists($savePath)) {
            File::makeDirectory($savePath, 0777, true, true);
        }

        $img->save($imagePath);
    }

    public function getAyahImage($lang, $sura, $ayah)
    {
        // البحث عن بيانات الآية
        $ayahData = Cache::remember("ayah_{$lang}_{$sura}_{$ayah}", self::CACHE_DURATION, function () use ($sura, $ayah) {
            return ArQuran::where('ar_sura_number', $sura)
                ->where('aya_number', $ayah)
                ->first();
        });

        // التحقق مما إذا كانت الآية موجودة
        if (! $ayahData) {
            return response()->json(['message' => 'الآية غير موجودة'], 404);
        }

        // توليد مسار الصورة
        $imagePath = storage_path("app/public/quran/{$lang}/{$lang}_{$sura}_{$ayah}.jpg");
        $imageUrl = file_exists($imagePath) ? asset("storage/quran/{$lang}/{$lang}_{$sura}_{$ayah}.jpg") : null;

        return response()->json([
            'surah' => $ayahData->ar_sura_number,
            'ayah' => $ayahData->aya_number,
            'text' => $ayahData->text,
            'image_url' => $imageUrl,
        ]);
    }
    public function getAyatWithImagesFiltered($lang = null, $sura = null)
    {
        $grouped = [];

        $languageDirs = $lang
            ? [ "quran/{$lang}" ]
            : Storage::disk('public')->directories('quran');

        foreach ($languageDirs as $dirPath) {
            $currentLang = basename($dirPath);
            $files = Storage::disk('public')->files($dirPath);

            foreach ($files as $filePath) {
                if (Str::endsWith($filePath, '.jpg')) {
                    $filename = basename($filePath, '.jpg');
                    $parts = explode('_', $filename);

                    if (count($parts) !== 3) continue;

                    [$fileLang, $fileSura, $ayah] = $parts;

                    if (($lang && $fileLang !== $lang) || ($sura && (int) $fileSura !== (int) $sura)) {
                        continue;
                    }

                    $grouped[$fileLang][$fileSura][] = [
                        'ayah'      => $ayah,
                        'image_url' => asset("storage/{$filePath}"),
                    ];
                }
            }
        }

        if (empty($grouped)) {
            return response()->json(['message' => 'No ayat images found for this criteria.'], 404);
        }

        return response()->json([
            'filter' => [
                'lang' => $lang,
                'sura' => $sura,
            ],
            'count' => array_sum(array_map(fn($langs) => array_sum(array_map('count', $langs)), $grouped)),
            'grouped_by_language' => $grouped,
        ]);
    }
}
