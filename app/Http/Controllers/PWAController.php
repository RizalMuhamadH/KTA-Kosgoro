<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class PWAController extends Controller
{
    public function index(){
        if(Auth::user() != null){
            return view('pwa.profile',[
                'data'  =>  User::where('email',Auth::user()->email)->with(['District','SubDistrict'])->first()
            ]);
        }else{
            return view('pwa.index');
        }
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
            'data'  =>  User::where('email',$request->email)->with(['District','SubDistrict'])->first()
        ]);
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
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

    public function download_kta($id){
        $pdf = PDF::loadView('pdf.kta',[
            'data'  => User::where('id',$id)->with(['SubDistrict'])->first()
        ]);
        $pdf->setPaper('A7','landscape');
        
        return $pdf->download('kta.pdf');
    }

}
