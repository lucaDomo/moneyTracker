<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Movement;
use Carbon\WeekDay;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AddMovementController extends Controller
{
    //
    public function show():View{

        $movement_type_id_default = 1;
        $categories = Category::where('user_id', auth()->user()->id)->where("movement_type_id", $movement_type_id_default)->get();

        return view('add-movement', ['categories'=>$categories]);
    }

    public function add(Request $request){
        
        
        /*
        echo $request->money;
        echo $request->day;
        echo $request->category;
        echo $request->type;
        echo $request->file;
        echo " ";
        */
        $date = new DateTime($request->day);
        /*
        echo $date->format(("Y"));
        echo " ";
        echo intval($date->format(("m")));
        echo " ";
        */
        $week = $date->format("W");
        $day = $date->format("w");
        /*
        echo $week;
        echo " ";
        echo $day;
        */
        $categories = Category::where('user_id', auth()->user()->id)->where('id', $request->category)->get();
        $category = $categories[0];
        $movement = new Movement;
        $movement->user_id = auth()->user()->id;
        $movement->category_id = $category->private_id;
        $movement->movement_type_id = $request->type;
        $movement->name = $request->name;
        $movement->week_number = $week;
        $movement->year = $date->format(("Y"));
        $movement->date = $request->day;
        $movement->money = $request->money;
        $movement->month_number = intval($date->format(("m")));
        $movement->day_number = $day;
        
        $movement->save();

        return redirect('dashboard')->with('status', 'Movimento salvato con successo!');
    }

}
