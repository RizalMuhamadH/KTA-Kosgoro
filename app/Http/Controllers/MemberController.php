<?php

namespace App\Http\Controllers;

use App\Mail\OTPMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function index(){

    }

    public function detail(Request $request){

    }

    public function generate_otp(Request $request){
        $tmp_user = "";
        if($request->email != null){
            $tmp_user = User::where('email',$request->email)->first();
        }else if($request->phone_number != null){
            $tmp_user = User::where('phone_number',$request->phone_number)->first();
        }
        if($tmp_user != null){
            $otp_before_hash = Str::random(6);
            $tmp_user->password = Hash::make($otp_before_hash);
            $tmp_user->otp_used = 0;
            $tmp_user->save();
            Mail::to($tmp_user->email)->send(new OTPMail($tmp_user, $otp_before_hash));
        }else{
            $result = [
                'code'  =>  '404',
                'type'  =>  'error',
            ];
            echo json_encode($result);
        }

    }

    public function login(Request $request){
        $request->validate([
            'password'   =>  'required'
        ]);
        if($request->email != null){
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'otp_used' => 0])){
                $tmp_user = User::where('email',$request->email)->first();
                $tmp_user->otp_used = 1;
                $tmp_user->token = Str::random(10);
                $tmp_user->save();
                return redirect('/home');
            }else{
                return redirect()->back()->with('message','Login gagal, silahkan cek kembali nomor telepon/email dan otp anda');
            }
        }elseif($request->phone_number != null){
            if(Auth::attempt(['phone_number' => $request->phone_number, 'password' => $request->password, 'otp_used' => 0])){
                $tmp_user = User::where('phone_number',$request->phone_number)->first();
                $tmp_user->otp_used = 1;
                $tmp_user->token = Str::random(10);
                $tmp_user->save();
                return redirect('/home');
            }else{
                return redirect()->back()->with('message','Login gagal, silahkan cek kembali nomor telepon/email dan otp anda');
            }
        }else{
            return redirect()->back()->with('message','Login gagal, silahkan cek kembali nomor telepon/email dan otp anda');
        }
    }
}
