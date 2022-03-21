<?php

namespace App\Http\Controllers;

use App\Models\CategoryEvent;
use App\Models\Position;
use Illuminate\Http\Request;

class CategoryEventController extends Controller
{
    public function index(){
        return view('events.category',[
            'positions' => Position::all()
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'name'  =>  'required|min:3|unique:event_categorys,name'
        ]);

        $result = CategoryEvent::create([
            'name' => $request->name
        ]);

        if($result){
            return response()->json(array([
                "message"   => "Category $request->name succesfully created",
                "type"      =>  "success",
                "code"      => true]),200);
        }else{
            return response()->json(array([
                "message"   => "Category $request->name failed to create",
                "type"      =>  "error",
                "code"      => false]),200);
        }
    }

    public function update(Request $request){
        $request->validate([
            'name'  =>  'required|min:3|unique:event_categorys,name,'.$request->id
        ]);

        $category = CategoryEvent::find($request->id);
        $category->name = $request->name;
        $category->slug = $category->generateSlug();
        $result = $category->save();
       
        if($result){
            return response()->json(array([
                "message"   => "Category $request->name succesfully updated",
                "type"      =>  "success",
                "code"      => true]),200);
        }else{
            return response()->json(array([
                "message"   => "Category $request->name failed to update",
                "type"      =>  "error",
                "code"      => false]),200);
        }
    }

    public function detail($id){
        return response()->json(CategoryEvent::find($id));
    }

    public function datatables(Request $request){
        $result['data'] = CategoryEvent::all();
        return response()->json($result,200);
    }

    public function delete(Request $request){
        $result = CategoryEvent::where('id',$request->id)->delete();
        if($result){
            return response()->json(array([
                "message"   => "Category  succesfully deleted",
                "type"      =>  "success",
                "code"      => true]),200);
        }else{
            return response()->json(array([
                "message"   => "Category  failed to delete",
                "type"      =>  "error",
                "code"      => false]),200);
        }
    }

    public function search(Request $request){

    }
}
