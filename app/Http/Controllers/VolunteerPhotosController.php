<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VolunteerPhotos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VolunteerPhotosController extends Controller{
    public function submitDesign(Request $r){
            $Rules = [
                'type' => 'required|in:quran,hadith',
                'design_id' => 'required',
                'user_id' => 'required'
            ];
            $Validator = Validator::make($r->all() , $Rules);
            if($Validator->fails()){
                return response(['message' => 'تأكد من تسجيل الدخول اولاً' ], 400);
            }
            else{
                $RequestData = $r->all();
                VolunteerPhotos::create($RequestData);
                return response()->json(['message' => 'تم التاكيد'], 200);
            }
    }
}
