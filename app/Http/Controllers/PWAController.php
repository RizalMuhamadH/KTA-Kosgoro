<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PWAController extends Controller
{
    public function index(){
        return view('pwa.index');
    }

    public function otp(Request $request){
        $user = User::where('email',$request->email)->first();
        if($user != null){
            return view('pwa.otp',['email' => $request->email]);
        }else{
            return redirect()->route('pwa.index')->with('message','Anda belum melakukan generate token');;
        }
    }

    public function register(Request $request){
        return view('pwa.register',[
            'data'  =>  User::where('id',$request->id)->first()
        ]);
    }

    public function profile(Request $request){
        return view('pwa.profile',[
            'data'  =>  User::where('email',$request->email)->with(['SubDistrict'])->first()
        ]);
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('pwa.index');
    }

    public function update($id){
        return view('pwa.update',[
            'data'  =>  User::where('id',$id)->with([
                'Province',
                'District',
                'SubDistrict',
                'SubDistrict',
                'Village'])->first()
            ]);
    }

}
