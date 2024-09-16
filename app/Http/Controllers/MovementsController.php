<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Movement;
use DateTime;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\alert;

class MovementsController extends Controller
{
    //
    public function detail(Request $request, string $id){
        $movements = Movement::where('user_id', auth()->user()->id)->where("id", $id)->get();
        if($movements==null||count($movements)==0){
            return redirect("/dashboard")->with('messagge-error', 'Il movimento che stai cercando di visualizzare non esiste!');
        }
        else{
            $movement = $movements[0];
            $categories = Category::where('user_id', auth()->user()->id)->where("private_id", $movement->category_id)->get();
            $category = $categories[0];
            $movement->category_name = $category->name;
            $movement->category_file = $category->file;
            $categories = Category::where('user_id', auth()->user()->id)->where("movement_type_id", $movement->movement_type_id)->get();
            return view('movement-detail', ['movement'=>$movement, 'categories'=>$categories]);
        }
        
    }

    public function update(Request $request, string $id){
        $action = $request->input('action');
        //echo $action;
        if($action=="Save"){
            $movements = Movement::where('user_id', auth()->user()->id)->where("id", $id)->get();
            $categories = Category::where('user_id', auth()->user()->id)->where("id", $request->category)->get();

            $movement = $movements[0];
            $category = $categories[0];
            $movement->category_id = $category->private_id;
            $movement->movement_type_id = $request->type;
            $movement->name = $request->name;
            $date = new DateTime($request->day);
            $week = $date->format("W");
            $day = $date->format("w");
            $movement->week_number = $week;
            $movement->year = $date->format(("Y"));
            $movement->date = $request->day;
            $movement->money = $request->money;
            $movement->month_number = intval($date->format(("m")));
            $movement->day_number = $day;
            
            $movement->save();
            return redirect('dashboard')->with('status', 'Movimento modificato con successo!');
        }else if($action=="Delete"){
            //Movement::find($id)->delete();
            Movement::where('user_id', auth()->user()->id)->where("id", $id)->delete();
            return redirect('dashboard')->with('status', 'Movimento eliminato con successo!');
        }

    }

    public function show(Request $request){

        echo $request->data_type;

        // (1) Prendere gli ultimi 5 movimenti

        /*
        $movements = Movement::orderBy('date', 'DESC')->get();
        // Prendere i nomi delle categorie e passarle
        $categories = Category::all();
        foreach ($movements as $movement){
            $category_id = $movement->category_id;
            $movement->category_name = $categories[$category_id-1]->name;
            $movement->category_file = $categories[$category_id-1]->file;
        }
        */
        $movements = DB::table('movements')
            ->join('categories', 'movements.category_id', '=', 'categories.private_id')
            ->where('movements.user_id', auth()->user()->id)
            ->select('movements.id', 'movements.name', 'movements.date', 'movements.movement_type_id', 'movements.money',
                    'categories.name as category_name', 'categories.file as category_file')
            ->get();

        return view('movements', ['movements'=>$movements]);
    }

    public function show_list(Request $request){


        // (1) Prendere gli ultimi 5 movimenti
        //$movements = Movement::orderBy('id', 'DESC')->get();
        // Prendere i nomi delle categorie e passarle
        $categories = Category::all();

        if ($request->query("data_type")=="year"){
            $year = intval($request->query("year"));
            //$movements = Movement::orderBy('date', 'DESC')->where('year',$year)->get();
            $movements = DB::table('movements')
                                ->join('categories', 'movements.category_id', '=', 'categories.private_id')
                                ->where('movements.user_id', auth()->user()->id)
                                ->where('year',$year)
                                ->select('movements.id', 'movements.name', 'movements.date', 'movements.movement_type_id', 'movements.money',
                                        'categories.name as category_name', 'categories.file as category_file')
                                ->orderBy('movements.date', 'DESC')
                                ->get();
            /*
            foreach ($movements as $movement){
                $category_id = $movement->category_id;
                $movement->category_name = $categories[$category_id-1]->name;
                $movement->category_file = $categories[$category_id-1]->file;
            }
            */
            return response()->json($movements);
        } else{
            if ($request->query("data_type")=="month"){
                $year = intval($request->query("year"));
                $month = intval($request->query("month"));
                //$movements = Movement::orderBy('date', 'DESC')->where('year',$year)->where("month_number",$month)->get();
                $movements = DB::table('movements')
                                ->join('categories', 'movements.category_id', '=', 'categories.private_id')
                                ->where('movements.user_id', auth()->user()->id)
                                ->where('year',$year)
                                ->where("month_number",$month)
                                ->select('movements.id', 'movements.name', 'movements.date', 'movements.movement_type_id', 'movements.money',
                                        'categories.name as category_name', 'categories.file as category_file')
                                ->orderBy('movements.date', 'DESC')
                                ->get();
                /*
                foreach ($movements as $movement){
                    $category_id = $movement->category_id;
                    $movement->category_name = $categories[$category_id-1]->name;
                    $movement->category_file = $categories[$category_id-1]->file;
                }
                */
                return response()->json($movements);
            }
            else{
                if ($request->query("data_type")=="week"){
                    $year = intval($request->query("year"));
                    $week_start = $request->query("weekstart")."/".$year;
                    $date = new DateTime($week_start);
                    $week = $date->format("W");
                    //$movements = Movement::orderBy('date', 'DESC')->where('year',$year)->where("week_number",$week)->get();
                    $movements = DB::table('movements')
                                ->join('categories', 'movements.category_id', '=', 'categories.private_id')
                                ->where('movements.user_id', auth()->user()->id)
                                ->where('year',$year)
                                ->where("week_number",$week)
                                ->select('movements.id', 'movements.name', 'movements.date', 'movements.movement_type_id', 'movements.money',
                                        'categories.name as category_name', 'categories.file as category_file')
                                ->orderBy('movements.date', 'DESC')
                                ->get();
                    /*
                    foreach ($movements as $movement){
                        $category_id = $movement->category_id;
                        $movement->category_name = $categories[$category_id-1]->name;
                        $movement->category_file = $categories[$category_id-1]->file;
                    }*/
                    //return response()->json(['mov'=>$movements, 'week'=>$week, 'start'=>$week_start]);
                    return response()->json($movements);
                }
                else{
                    if ($request->query("data_type")=="day"){
                        $date = new DateTime(intval($request->query("month")) . "/" . intval($request->query("day")) . "/" . intval($request->query("year")));
                        //$movements = Movement::orderBy('date', 'DESC')->where('date',$date->format("Y-m-d"))->get();
                        $movements = DB::table('movements')
                                ->join('categories', 'movements.category_id', '=', 'categories.private_id')
                                ->where('movements.user_id', auth()->user()->id)
                                ->where('date',$date->format("Y-m-d"))
                                ->select('movements.id', 'movements.name', 'movements.date', 'movements.movement_type_id', 'movements.money',
                                        'categories.name as category_name', 'categories.file as category_file')
                                ->orderBy('movements.date', 'DESC')
                                ->get();
                        /*
                        foreach ($movements as $movement){
                            $category_id = $movement->category_id;
                            $movement->category_name = $categories[$category_id-1]->name;
                            $movement->category_file = $categories[$category_id-1]->file;
                        }
                        */
                        //return response()->json(['mov'=>$movements, 'week'=>$week, 'start'=>$week_start]);
                        return response()->json($movements);
                    }
                }
            }
        }

        
    }
}
