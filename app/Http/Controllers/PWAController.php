<?php

namespace App\Http\Controllers;

use App\Models\CategoryEvent;
use App\Models\CategoryNews;
use App\Models\Events;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class PWAController extends Controller
{
    public function index(){
        if(Auth::user() != null){
            return view('pwa.dashboard');
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
            'data'  =>  User::where('email',$request->email)->with(['Province'])->first()
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
            'data'  => User::where('id',$id)->with(['Province'])->first()
        ]);
        $customPaper = array(0,0,140.38,283.80);
        $pdf->setPaper($customPaper,'landscape');

        return $pdf->download('kta.pdf');
    }

    public function news(){
        return view('pwa.news',[
            'news'  => News::with(['Category','Author'])->orderBy('created_at')->paginate(10)
        ]);
    }

    public function read_news($category, $id, $slug){
        $tmp_category = CategoryNews::where('slug',$category)->first();
        $data = News::where('id', $id)->where('category_id',$tmp_category->id)->where('slug',$slug)->with(['Category','Author' => function($query){
            return $query->select('id','name');
        }])->first();
        if($data){
            return view('pwa.read_news',[
                'news'  => $data
            ]);
        }else{
            abort(404);
        }
    }

    public function read_event($category, $id, $slug){
        $tmp_category = CategoryEvent::where('slug',$category)->first();
        $data = Events::where('id', $id)->where('category_id',$tmp_category->id)->where('slug',$slug)->with(['Category'])->first();
        if($data){
            return view('pwa.read_event',[
                'event'  => $data
            ]);
        }else{
            abort(404);
        }
    }

    public function events(){
        return view('pwa.events',[
            'events'  => Events::with(['Category','Author'])->orderBy('created_at')->paginate(10)
        ]);
    }

    public function contact(){
        return view('pwa.contact');
    }

}
