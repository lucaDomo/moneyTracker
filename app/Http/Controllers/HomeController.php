<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Movement;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Date;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use DateTime;

class HomeController extends Controller
{
    //
    public function show():View{

        // (1) Prendere gli ultimi 5 movimenti

        $movements = DB::table('movements')
            ->join('categories', 'movements.category_id', '=', 'categories.private_id')
            ->where('movements.user_id', auth()->user()->id)
            ->orderBy('movements.created_at', 'DESC')
            ->select('movements.id', 'movements.name', 'movements.date', 'movements.movement_type_id', 'movements.money',
                    'categories.name as category_name', 'categories.file as category_file')
            ->take(5)
            ->get();

        // (2) Calcolare il resoconto mensile
        $current_month = intval(date("m"));
        $current_year = intval(date("Y"));
        $current_month_movements = Movement::where('user_id', auth()->user()->id)
                                            ->where('month_number',$current_month)->where('year', $current_year)->get();
        $money_out = 0;
        $money_in = 0;
        foreach ($current_month_movements as $movement){
            if($movement->movement_type_id==2){ //entrata
                $money_in += $movement->money;
            } else{
                $money_out += $movement->money;
            }
        }

        return view('dashboard', ['movements'=>$movements,
                                  'month_in'=>$money_in,
                                  'month_out'=>$money_out,
                                ]);

    }

    public function getResoconto(Request $request){
        $year = intval($request->query("year"));
        $month = intval($request->query("month"));

        $current_month_movements = Movement::where('user_id', auth()->user()->id)->where('month_number',$month)->where('year', $year)->get();
        $money_out = 0;
        $money_in = 0;
        $movement_lists = array();
        
        foreach ($current_month_movements as $movement){
            if($movement->movement_type_id==2){ //entrata
                $money_in += $movement->money;
            } else{
                $money_out += $movement->money;
            }
        }

        $categories = Category::where('user_id', auth()->user()->id)->get();
        foreach($categories as $category){
            $movements_temp = Movement::where('user_id', auth()->user()->id)->where('month_number',$month)
                                        ->where('year', $year)->where('category_id',$category->private_id)->get();
            $money_temp = 0;
            foreach($movements_temp as $movement_temp){
                $money_temp += $movement_temp->money;
            }
            $temp = new \stdClass();
            $temp->category = $category->name;
            $temp->money = $money_temp;
            $temp->type = $category->movement_type_id;
            $movement_lists[] = $temp;

        }
        
        return response()->json([
            'month_in' => $money_in,
            'month_out' => $money_out,
            'categories_movement' => $movement_lists,
        ]);

    }

    public function getGraphValues(Request $request){

        if ($request->query("type")=="month"){
            $year = intval($request->query("year"));
            $month = intval($request->query("month"));
            $movements = Movement::where('user_id', auth()->user()->id)->where('year',$year)->where("month_number",$month)->get();

            $num_days_in_month = $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
            
            $graph_values_in = array_fill(0, $num_days_in_month, 0);
            $graph_values_out = array_fill(0, $num_days_in_month, 0);
            
            foreach ($movements as $movement){
                $date = new DateTime($movement->date);
                $index = $date->format('j')-1;
                if($movement->movement_type_id==2){ //entrata
                    $graph_values_in[$index] += $movement->money;
                } else{
                    $graph_values_out[$index] += $movement->money;
                }
            }
        }
        elseif ($request->query("type")=="year"){
            $year = intval($request->query("year"));
            $movements = Movement::where('user_id', auth()->user()->id)->where('year',$year)->get();

            $num_months = 12;
            
            $graph_values_in = array_fill(0, $num_months, 0);
            $graph_values_out = array_fill(0, $num_months, 0);
            
            foreach ($movements as $movement){
                $index = $movement->month_number-1;
                if($movement->movement_type_id==2){ //entrata
                    $graph_values_in[$index] += $movement->money;
                } else{
                    $graph_values_out[$index] += $movement->money;
                }
            }
        }
        elseif ($request->query("type")=="week"){
            $year = intval($request->query("year"));
            $week_start = $request->query("weekstart")."/".$year;
            $date = new DateTime($week_start);
            $week = $date->format("W");
            $movements = Movement::where('user_id', auth()->user()->id)->where('year',$year)->where("week_number",$week)->get();

            $num_days_in_week = 7;
            
            $graph_values_in = array_fill(0, $num_days_in_week, 0);
            $graph_values_out = array_fill(0, $num_days_in_week, 0);
            
            foreach ($movements as $movement){
                $index = $movement->day_number-1;
                if ($index==-1){ #domenica
                    $index = 6;
                }
                if($movement->movement_type_id==2){ //entrata
                    $graph_values_in[$index] += $movement->money;
                } else{
                    $graph_values_out[$index] += $movement->money;
                }
            }
        }
        

        return response()->json([
            'graph_in' => $graph_values_in,
            'graph_out' => $graph_values_out
        ]);

    }

    public function getStatistics(Request $request){

        $total_out = 0;
        $total_in = 0;
        $movements_categories_out = array();
        $movements_categories_in = array();
        $categories = Category::where('user_id', auth()->user()->id)->get();

        if ($request->query("type")=="month"){
            $year = intval($request->query("year"));
            $month = intval($request->query("month"));

            foreach($categories as $category){
                $movements_temp = Movement::where('user_id', auth()->user()->id)->where('month_number',$month)->where('year', $year)
                                            ->where('category_id',$category->private_id)->get();
                $money_temp = 0;
                foreach($movements_temp as $movement_temp){
                    $money_temp += $movement_temp->money;
                }
                if ($category->movement_type_id==2) { //entrata
                    $total_in += $money_temp;
                    if ($money_temp>0) {
                        $temp = new \stdClass();
                        $temp->category = $category->name;
                        $temp->money = $money_temp;
                        $movements_categories_in[] = $temp;
                    }
                }else{
                    $total_out += $money_temp;
                    if ($money_temp>0) {
                        $temp = new \stdClass();
                        $temp->category = $category->name;
                        $temp->money = $money_temp;
                        $movements_categories_out[] = $temp;
                    }
                }
            }
        }
        elseif ($request->query("type")=="year"){
            $year = intval($request->query("year"));

            foreach($categories as $category){
                $movements_temp = Movement::where('user_id', auth()->user()->id)->where('year', $year)->where('category_id',$category->private_id)->get();
                $money_temp = 0;
                foreach($movements_temp as $movement_temp){
                    $money_temp += $movement_temp->money;
                }
                if ($category->movement_type_id==2) { //entrata
                    $total_in += $money_temp;
                    if ($money_temp>0) {
                        $temp = new \stdClass();
                        $temp->category = $category->name;
                        $temp->money = $money_temp;
                        $movements_categories_in[] = $temp;
                    }
                }else{
                    $total_out += $money_temp;
                    if ($money_temp>0) {
                        $temp = new \stdClass();
                        $temp->category = $category->name;
                        $temp->money = $money_temp;
                        $movements_categories_out[] = $temp;
                    }
                }
            }
        }
        elseif ($request->query("type")=="week"){
            $year = intval($request->query("year"));
            $week_start = $request->query("weekstart")."/".$year;
            $date = new DateTime($week_start);
            $week = $date->format("W");

            foreach($categories as $category){
                $movements_temp = Movement::where('user_id', auth()->user()->id)->where("week_number",$week)->where('year', $year)
                                            ->where('category_id',$category->private_id)->get();
                $money_temp = 0;
                foreach($movements_temp as $movement_temp){
                    $money_temp += $movement_temp->money;
                }
                if ($category->movement_type_id==2) { //entrata
                    $total_in += $money_temp;
                    if ($money_temp>0) {
                        $temp = new \stdClass();
                        $temp->category = $category->name;
                        $temp->money = $money_temp;
                        $movements_categories_in[] = $temp;
                    }
                }else{
                    $total_out += $money_temp;
                    if ($money_temp>0) {
                        $temp = new \stdClass();
                        $temp->category = $category->name;
                        $temp->money = $money_temp;
                        $movements_categories_out[] = $temp;
                    }
                }
            }
        }

        return response()->json([
            'money_in' => $total_in,
            'money_out' => $total_out,
            'balance' => ($total_in - $total_out),
            'movements_categories_in' => $movements_categories_in,
            'movements_categories_out' => $movements_categories_out,
        ]);

    }
}
