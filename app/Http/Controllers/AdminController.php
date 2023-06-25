<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VolunteerPhotos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller{
    public function index(){
        $AllUsers = User::where('active', 1)->with('UserSubmits')->get();
        return view('dashboard', compact('AllUsers'));
    }
    public function usersList(){
        $AllUsers = User::all()->except(Auth::id())->paginate(2);
        return view('admin.users.list', compact('AllUsers'));
    }
    public function userEdit($id){
        $TheUser = User::findOrFail($id);
        return view('admin.users.edit', compact('TheUser'));
    }
    public function postUserEdit(Request $r, $id){
        $TheUser = User::findOrFail($id);
            $Data = $r->all();
            $r->has('active') ? $Data['active'] = 1 : $Data['active'] = 0;
            $r->has('role') ? $Data['role'] = 1 : $Data['role'] = 0;
            $TheUser->update($Data);
            return redirect()->route('usersList')->withSuccess("تم تعديل المستخدم بنجاح");
    }
    public function getUserReport($id){
        $UserDesigns = VolunteerPhotos::where('user_id', $id)->with('User', 'Quran')->get();
        // dd($UserDesigns);
        return view('admin.users.report', compact('UserDesigns'));
    }
    public function logout(){
        if(Auth::check()){
            Auth::logout();
            return redirect()->route('login');
        }else{
        return redirect()->route('login');
        }
    }
}
