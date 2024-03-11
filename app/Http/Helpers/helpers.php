<?php
use Illuminate\Support\Facades\Cookie;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Cart;
use App\Models\User;
use App\Models\EventLog;
use Illuminate\Support\Facades\Http;

    function HadithImageSrc($lang, $id){
        return url('storage/app/public/hadith/').'/'.$lang.'/'.$lang.'_'.$id.'.jpg';
    }
    function QuranImageSrc($lang, $sura_id, $aya_id){
        return url('storage/app/public/quran/').'/'.$lang.'/'.$lang.'_'.$sura_id.'_'.$aya_id.'.jpg';
    }
    function LanguagesLIst(){
        $AllLanguages = Http::accept('application/json')->get('https://hadeethenc.com/api/v1/languages');
        return $AllLanguages->object();
    }
?>
