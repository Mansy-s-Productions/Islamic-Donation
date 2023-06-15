<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LanguageController extends Controller{
    public function getAdminLanguages(){
        $AllLanguages = Language::all();
        return view('admin.languages.all', compact('AllLanguages'));
    }
    public function getCreateLanguage(){
        return view('admin.languages.new');
    }
    public function postCreateLanguage(Request $r){
        $Rules = [
            'lang_name' => 'required',
            'lang_code' => 'required',
            'order' => 'numeric',
        ];
        $Messages =[
            'order.numeric' => 'يجب ان يكون الترتيب بارقام فقط'
        ];
        $Validator = Validator::make($r->all(), $Rules, $Messages);
        if($Validator->fails()){
            return back()->withErrors($Validator->errors()->all());
        }else{
            $LangData = $r->all();
            $LangData['lang_code'] = strtolower($LangData['lang_code']);
            // dd($LangData);
            Language::create($LangData);
            return redirect()->route('admin.languages.all')->withSuccess("تم إضافة اللغة بنجاح");
        }
    }
    public function getEditLanguage($id){
        $TheLanguage = Language::findOrFail($id);
        return view('admin.languages.edit', compact('TheLanguage'));
    }
    public function postEditLanguage(Request $r, $id){
        $TheLanguage = Language::findOrFail($id);
        $Rules = [
            'lang_name' => 'required',
            'lang_code' => 'required',
            'order' => 'numeric',
        ];
        $Messages =[
            'order.numeric' => 'يجب ان يكون الترتيب بارقام فقط'
        ];
        $Validator = Validator::make($r->all(), $Rules, $Messages);
        if($Validator->fails()){
            return back()->withErrors($Validator->errors()->all());
        }else{
            $LangData = $r->all();
            $LangData['lang_code'] = strtolower($LangData['lang_code']);
            $TheLanguage->update($LangData);
            return redirect()->route('admin.languages.all')->withSuccess("تم تعديل اللغة بنجاح");
        }
    }
    public function deleteLanguage($id){
        Language::findOrFail($id)->delete();
        return redirect()->route('admin.languages.all')->withSuccess("تم مسح اللغة بنجاح");
    }
}
