<?php

namespace App\Http\Controllers;

use App\Models\CategoryNews;
use App\Models\News;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use PDO;

class NewsController extends Controller
{
    public function index($type)
    {
        return view('news.index', [
            'categories'    =>  CategoryNews::all(),
            'type'          =>  $type,
            'positions'     =>  Position::all()
        ]);
    }

    public function createUpdate($type)
    {
        return view('news.create', [
            'categories'    =>  CategoryNews::all(),
            'positions'     =>  Position::all()
        ]);
    }

    public function store(Request $request)
    {
        $status = "";
        if ($request->status == "1") {
            $status = "Draft";
        } elseif ($request->status == "2") {
            $status = "Published";
        } elseif ($request->status == "3") {
            $status = "Deleted";
        }

        $filename = "";
        $request->validate([
            'title'         =>  'required|min:10|max:40',
            'description'   =>  'required|min:100|max:140',
            'body'          =>  'required',
            'featured'      =>  'required',
            'category'      =>  'required',
            'status'        =>  'required',
            'thumbnail'     =>  'required|mimes:jpg,png,jpeg'
        ]);

        if ($request->hasFile('thumbnail')) {
            $filename = Str::slug($request->title);
            $filename = $filename . "." . $request->file('thumbnail')->getClientOriginalExtension();
        }

        $article =  new News();
        $article->title                     = $request->title;
        $article->description               = $request->description;
        $article->body                      = $request->body;
        $article->source                    = isset($request->source) ? $request->source : '';
        $article->source_link               = isset($request->source_link) ? $request->source_link : '';
        $article->featured                  = $request->featured;
        $article->category_id               = $request->category;
        $article->user_id                   = Auth::user()->id;
        $article->status                    = $status;
        $article->meta_description          = $request->description;
        $article->thumbnail                 = $filename;
        $result = $article->save();

        if ($result) {
            $request->file('thumbnail')->storeAs("article/" . $article->id . "/", $filename, 'public');
            return Redirect::route('news.index', ['type' => $request->status])->with(['message' => "Article Succesfully Created"]);
        } else {
            return Redirect::back()->with(['message' => "Article Failed Created"]);
        }
    }

    public function datatables(Request $request)
    {
        $status = "";
        if ($request->status == "1") {
            $status = "Draft";
        } elseif ($request->status == "2") {
            $status = "Published";
        } elseif ($request->status == "3") {
            $status = "Deleted";
        }

        $tmp_query = News::select(['id', 'slug', 'title', 'user_id', 'category_id', 'status', 'created_at', 'updated_at']);
        if ($request->category != "All") {
            $tmp_query->where('category_id', $request->category);
        }
        $result['data'] = $tmp_query->where('status', $status)->with(['Category', 'Author' => function ($query) {
            return $query->select('id', 'name');
        }])->orderBy('created_at','desc')->get();
        return response()->json($result, 200);
    }

    public function detail(Request $request, $id)
    {
        if ($request->ajax()) {
            if ($id == null) {
                $response = [
                    'code'          => 200,
                    'data'          => null,
                    'message'       => "Data Tidak Ditemukan"
                ];
            } else {
                $data = News::find($id);
                if ($data) {
                    $response = [
                        'code'          => 200,
                        'data'          => $data,
                        'message'       => "Data Ditemukan"
                    ];
                }
            }
            return response($response, 200);
        } else {
            if ($id == null) {
                abort(404);
            } else {
                $data = News::find($id);
                if ($data) {
                    return view('news.update', [
                        'categories'    =>  CategoryNews::all(),
                        'positions'     =>  Position::all(),
                        'data'          =>  $data
                    ]);
                }
            }
        }
    }

    public function update(Request $request)
    {
        $status = "";
        $change_thumbnail = false;
        if ($request->status == "1") {
            $status = "Draft";
        } elseif ($request->status == "2") {
            $status = "Published";
        } elseif ($request->status == "3") {
            $status = "Deleted";
        }

        $filename = "";
        $request->validate([
            'title'         =>  'required|min:10|max:40',
            'description'   =>  'required|min:100|max:140',
            'body'          =>  'required',
            'featured'      =>  'required',
            'category'      =>  'required',
            'status'        =>  'required',
            'id'            =>  'required',
        ]);

        if ($request->hasFile('thumbnail')) {
            $filename = Str::slug($request->title);
            $filename = $filename . "." . $request->file('thumbnail')->getClientOriginalExtension();
            $change_thumbnail = true;
        }

        $article =  News::find($request->id);
        $article->title                     = $request->title;
        $article->description               = $request->description;
        $article->body                      = $request->body;
        $article->source                    = isset($request->source) ? $request->source : '';
        $article->source_link               = isset($request->source_link) ? $request->source_link : '';
        $article->featured                  = $request->featured;
        $article->category_id               = $request->category;
        $article->user_id                   = Auth::user()->id;
        $article->status                    = $status;
        $article->meta_description          = $request->description;
        if ($change_thumbnail) {
            $article->thumbnail                 = $filename;
        }
        $result = $article->save();

        if ($result) {
            if ($change_thumbnail) {
                $request->file('thumbnail')->storeAs("article/" . $request->id . "/", $filename, 'public');
            }
            return Redirect::route('news.index', ['type' => $request->status])->with(['message' => "Article Succesfully Updated"]);
        } else {
            return Redirect::back()->with(['message' => "Article Failed Updated"]);
        }
    }

    public function read($category, $id, $slug)
    {
        $data = News::where('id', $id)->where('category_id', $category)->where('slug', $slug)->with(['Category', 'Author' => function ($query) {
            return $query->select('id', 'name');
        }])->first();
        if ($data) {
            $response = [
                'code'          => 200,
                'data'          => $data,
                'message'       => "Data Ditemukan"
            ];
        } else {
            $response = [
                'code'          => 200,
                'data'          => null,
                'message'       => "Data Tidak Ditemukan"
            ];
        }

        return response($response, 200);
    }

    public function delete(Request $request)
    {
        $result = News::where('id', $request->id)->update(['status' => 'Deleted']);
        if ($result) {
            return response()->json($result = array([
                "message"   => "Data berhasil dihapus",
                "type"      => "success",
                "code"    => true
            ]), 200);
        } else {
            return response()->json($result = array([
                "message"   => "Data gagal dihapus",
                "type"      => "error",
                "code"    => false
            ]), 200);
        }
    }

    public function recover(Request $request)
    {
        $result = News::where('id', $request->id)->update(['status' => 'Draft']);
        if ($result) {
            return response()->json($result = array([
                "message"   => "Data berhasil dikembalikan",
                "type"      => "success",
                "code"    => true
            ]), 200);
        } else {
            return response()->json($result = array([
                "message"   => "Data gagal dikembalikan",
                "type"      => "error",
                "code"    => false
            ]), 200);
        }
    }

    public function getNews(Request $request)
    {
        $news = News::with(['Category', 'Author' => function ($query) {
            return $query->select('id', 'name');
        }])->where('status', 'Published')->orderBy('created_at','desc')->get();
        if ($news != null) {
            $response = [
                'code'      =>  200,
                'data'      =>  $news,
                'message'   =>  "Data Ditemukan"
            ];
            return response($response, 200);
        } else {
            $response = [
                'code'      =>  500,
                'data'      =>  null,
                'message'   =>  "Data Tidak Ditemukan"
            ];
            return response($response, 200);
        }
    }

    public function getNewsByCategory(Request $request)
    {
        $category = CategoryNews::where('slug', $request->category)->first();
        $news = News::where('category_id', $category->id)->with(['Category', 'Author' => function ($query) {
            return $query->select('id', 'name');
        }])->where('status', 'Published')->orderBy('created_at','desc')->get();
        if ($news != null) {
            $response = [
                'code'      =>  200,
                'data'      =>  $news,
                'message'   =>  "Data Ditemukan"
            ];
            return response($response, 200);
        } else {
            $response = [
                'code'      =>  500,
                'data'      =>  null,
                'message'   =>  "Data Tidak Ditemukan"
            ];
            return response($response, 200);
        }
    }

    public function readNews(Request $request)
    {
        $user = User::where('token', $request->token)->first();
        if ($user) {
            $category = CategoryNews::where('slug', $request->category)->first();
            $data = News::where('id', $request->id)->where('category_id', $category->id)->where('slug', $request->slug)->with(['Category', 'Author' => function ($query) {
                return $query->select('id', 'name');
            }])->first();
            if ($data != null) {
                $response = [
                    'code'      =>  200,
                    'data'      =>  $data,
                    'message'   =>  "Data Ditemukan"
                ];
                return response($response, 200);
            } else {
                $response = [
                    'code'      =>  500,
                    'data'      =>  null,
                    'message'   =>  "Data Tidak Ditemukan"
                ];
                return response($response, 200);
            }
        } else {
            $response = [
                'code'      =>  403,
                'data'      =>  null,
                'message'   =>  "Silahkan Login Terlebih Dahulu!"
            ];
            return response($response, 403);
        }
    }
}
