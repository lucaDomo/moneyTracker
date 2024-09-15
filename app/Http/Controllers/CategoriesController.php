<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Movement;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoriesController extends Controller
{
    //
    public function show():View{
        $categories_out = Category::where('user_id', auth()->user()->id)->where('movement_type_id',1)->get();
        $categories_in = Category::where('user_id', auth()->user()->id)->where('movement_type_id',2)->get();
        return view('categories', ['categories_out'=>$categories_out,'categories_in'=>$categories_in]);
    }

    public function saveCategory(Request $request){
        $file = $request->input('link');
        $name = $request->input('name');
        $movement_type = intval($request->input('type'));
        $id = $request->input('id');

        if ($id==-1){
            $category = new Category();
        } else{
            $category = Category::find($id);
        }
        $category->name = $name;
        $category->file = $file;
        $category->user_id = auth()->user()->id;
        $category->movement_type_id = $movement_type;
        $category->save();

        return response()->json([
            'success' => true,
            'category' => $category
        ]);
    }

    public function deleteCategory(Request $request){
        $id = $request->input('id');
        $category = Category::where('id', $id)->get();
        $movements = Movement::where('user_id', auth()->user()->id)->where("category_id", $category[0]->private_id)->get();
        if (count($movements)>0){
            return response()->json([
                'success' => false,
                'messagge' => "Impossibile eliminare la categoria. Ci sono movimenti salvati con essa.\nNecessario eliminare o modificare tali movimenti."
            ]);
        }
        
        if ($category[0]->user_id == auth()->user()->id){
            Category::find($id)->delete();
            return response()->json([
                'success' => true
            ]);
        }
        return response()->json([
            'success' => false
        ]);
        
    }
}
