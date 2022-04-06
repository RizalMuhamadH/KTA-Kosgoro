<?php

namespace App\Http\Controllers;

use App\Models\CategoryEvent;
use App\Models\Events;
use App\Models\Position;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;



class EventController extends Controller
{
    public function index(){
        return view('events.index',[
            'categories'    =>  CategoryEvent::all(),
            'positions'     =>  Position::all()
        ]);
    }

    public function create(){
        return view('events.create',[
            'categories'    =>  CategoryEvent::all(),
            'positions'     =>  Position::all()
        ]); 
    }

    public function store(Request $request){
        $filename = "";
        $request->validate([
            'title'         =>  'required|min:10|max:40',
            'description'   =>  'required|min:20|max:140',
            'body'          =>  'required',
            'start_date'    =>  'required|date',
            'end_date'      =>  'required|date',
            'featured'      =>  'required',
            'category'      =>  'required',
            'thumbnail'     =>  'required|mimes:jpg,png,jpeg'          
        ]);

        if($request->hasFile('thumbnail')){
            $filename = Str::slug($request->title);
            $filename = $filename.".".$request->file('thumbnail')->getClientOriginalExtension();
        }
       
        $event =  new Events();
        $event->title                     = $request->title;
        $event->description               = $request->description;
        $event->body                      = $request->body;
        $event->featured                  = $request->featured;
        $event->category_id               = $request->category;
        $event->start_date                = $request->start_date;
        $event->end_date                  = $request->end_date;
        $event->category_id               = $request->category;
        $event->meta_description          = $request->description;
        $event->thumbnail                 = $filename;
        $result = $event->save();

        if($result){
            $request->file('thumbnail')->storeAs("events/".$event->id."/",$filename,'public');
            return Redirect::route('events.index')->with(['message' => "Event Succesfully Created"]);
        }else{
            return Redirect::back()->with(['message' => "Event Failed Created"]);
        }   
    }

    public function datatables(Request $request){
        $tmp_query = Events::select(['id','slug','title','category_id','start_date','end_date']);
        if($request->category != "All"){
            $tmp_query->where('category_id',$request->category);
        }
        $result['data'] = $tmp_query->with(['Category'])->get();
        return response()->json($result,200);
    }

    public function detail(Request $request, $id){
        if($request->ajax()){
            if($id == null){
                $response = [
                    'code'          => 200,
                    'data'          => null,
                    'message'       => "Data Tidak Ditemukan"
                ];
            }else{
                $data = Events::find($id);
                if($data){
                    $response = [
                        'code'          => 200,
                        'data'          => $data,
                        'message'       => "Data Ditemukan"
                    ];
                }
            }
            return response($response, 200);
        }else{
            if($id == null){
                abort(404);
            }else{
                $data = Events::find($id);
                if($data){
                    return view('events.update',[
                        'categories'    =>  CategoryEvent::all(),
                        'positions'     =>  Position::all(),
                        'data'          =>  $data
                    ]); 
                }
            }
        }

    }

    public function update(Request $request){
        $filename = "";
        $change_thumbnail = false;
        $request->validate([
            'title'         =>  'required|min:10|max:40',
            'description'   =>  'required|min:20|max:140',
            'body'          =>  'required',
            'start_date'    =>  'required|date',
            'end_date'      =>  'required|date',
            'featured'      =>  'required',
            'category'      =>  'required',         
        ]);


        if($request->hasFile('thumbnail')){
            $filename = Str::slug($request->title);
            $filename = $filename.".".$request->file('thumbnail')->getClientOriginalExtension();
            $change_thumbnail = true;
        }
       
       
        $event = Events::find($request->id);
        $event->title                     = $request->title;
        $event->description               = $request->description;
        $event->body                      = $request->body;
        $event->featured                  = $request->featured;
        $event->category_id               = $request->category;
        $event->start_date                = $request->start_date;
        $event->end_date                  = $request->end_date;
        $event->category_id               = $request->category;
        $event->meta_description          = $request->description;
        $event->thumbnail                 = $filename;
        if($change_thumbnail){
            $event->thumbnail                 = $filename;
        }
        $result = $event->save();

        if($result){
            if($change_thumbnail){
                $request->file('thumbnail')->storeAs("events/".$request->id."/",$filename,'public');
            }
            return Redirect::route('events.index',['type' => $request->status])->with(['message' => "Event Succesfully Updated"]);
        }else{
            return Redirect::back()->with(['message' => "Event Failed Updated"]);
        }   
    }

    public function read($category, $id, $slug){
        $data = Events::where('id', $id)->where('category_id',$category)->where('slug',$slug)->with(['Category','Author'])->first();
        if($data){
            $response = [
                'code'          => 200,
                'data'          => $data,
                'message'       => "Data Ditemukan"
            ];
        }else{
            $response = [
                'code'          => 200,
                'data'          => null,
                'message'       => "Data Tidak Ditemukan"
            ];
        }
       
        return response($response, 200);
    }

    public function delete(Request $request){ 
        $result = Events::where('id',$request->id)->delete();
        if($result){
            return response()->json($result = array([
                "message"   => "Data berhasil dihapus",
                "type"      => "success",
                "code"    => true]),200);

        }else{
            return response()->json($result = array([
                "message"   => "Data gagal dihapus",
                "type"      => "error",
                "code"    => false]),200);
        }


    }

    public function recover(Request $request){ 
        $result = Events::where('id',$request->id)->update(['status' => 'Draft']);
        if($result){
            return response()->json($result = array([
                "message"   => "Data berhasil dikembalikan",
                "type"      => "success",
                "code"    => true]),200);

        }else{
            return response()->json($result = array([
                "message"   => "Data gagal dikembalikan",
                "type"      => "error",
                "code"    => false]),200);
        }
    }

    public function getEvent(Request $request){
        $user = User::where('token',$request->token)->first();
        if($user){
            $event = Events::with(['Category'])->get();
            if($event != null){
                $response = [
                    'code'      =>  200,
                    'data'      =>  $event,
                    'message'   =>  "Data Ditemukan"
                ];
                return response($response, 200);
            }else{
                $response = [
                    'code'      =>  500,
                    'data'      =>  null,
                    'message'   =>  "Data Tidak Ditemukan"
                ];
                return response($response, 200);
            }
        }else{
            $response = [
                'code'      =>  403,
                'data'      =>  null,
                'message'   =>  "Silahkan Login Terlebih Dahulu!"
            ];
            return response($response, 403);
        }
    }

    public function getEventByCategory(Request $request){
        $user = User::where('token',$request->token)->first();
        if($user){
            $category = CategoryEvent::where('slug',$request->category)->first();
            $event = Events::where('category_id',$category->id)->with(['Category'])->get();
            if($event != null){
                $response = [
                    'code'      =>  200,
                    'data'      =>  $event,
                    'message'   =>  "Data Ditemukan"
                ];
                return response($response, 200);
            }else{
                $response = [
                    'code'      =>  500,
                    'data'      =>  null,
                    'message'   =>  "Data Tidak Ditemukan"
                ];
                return response($response, 200);
            }
        }else{
            $response = [
                'code'      =>  403,
                'data'      =>  null,
                'message'   =>  "Silahkan Login Terlebih Dahulu!"
            ];
            return response($response, 403);
        }
    }

    public function readEvent(Request $request){
        $user = User::where('token',$request->token)->first();
        if($user){
            $category = CategoryEvent::where('slug',$request->category)->first();
            $data = Events::where('id', $request->id)->where('category_id',$category->id)->where('slug',$request->slug)->with(['Category'])->first();
            if($data != null){
                $response = [
                    'code'      =>  200,
                    'data'      =>  $data,
                    'message'   =>  "Data Ditemukan"
                ];
                return response($response, 200);
            }else{
                $response = [
                    'code'      =>  500,
                    'data'      =>  null,
                    'message'   =>  "Data Tidak Ditemukan"
                ];
                return response($response, 200);
            }
        }else{
            $response = [
                'code'      =>  403,
                'data'      =>  null,
                'message'   =>  "Silahkan Login Terlebih Dahulu!"
            ];
            return response($response, 403);
        }
    }
}
