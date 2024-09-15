<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    //
    public function getCategoriesByMovementType(Request $request){
        
        $movement_type_id = $request->query("movement_type_id");
        $categories = Category::where('user_id', auth()->user()->id)->where("movement_type_id", $movement_type_id)->get();

        return response()->json([
            'categories'=>$categories
        ]);
    }
}
