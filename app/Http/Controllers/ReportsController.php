<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpenditureModel;
use App\Models\ExpType;
use App\Models\BillsType;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    function __construct(){
        session_start();
    }
    public function bydate(Request $req)
    {
        if(isset($_POST['submit']))
        {
            $getdatabydate = ExpenditureModel::where('date', $req->date)->get(['exp','bills','amount','date','desc']);
            $total_amount = DB::select('SELECT sum(amount) AS total_amount FROM `expenditure` WHERE date="'.$req->date.'"');
            return view('reports/bydate',['getdatabydate'=>$getdatabydate,'total_amount'=>$total_amount]);
        }
        return view('reports/bydate');
    }
    public function bymonth(Request $req)
    {
        if(isset($_POST['submit']))
        {
            $exp_type = ExpType::get();
            $minmonthyear = DB::select('SELECT MIN(YEAR(date)) as min_year ,MAX(YEAR(date)) as max_year FROM expenditure');
            $databymonthcount = DB::select('SELECT COUNT(*) AS month_count FROM `expenditure` where MONTH(date)='.$req->month.' AND YEAR(date)='.$req->year);
            $databymonth = DB::select('SELECT * FROM `expenditure` where MONTH(date)='.$req->month.' AND YEAR(date)='.$req->year);
            $total_amount = DB::select('SELECT sum(amount) as total_amount, COUNT(*) AS total_count FROM `expenditure` where MONTH(date)='.$req->month.' AND YEAR(date)='.$req->year);
            return view('reports/bymonth',['databymonth'=>$databymonth, 'minmonthyear'=>$minmonthyear,'total_amount'=>$total_amount,'exp_type'=>$exp_type,'month'=>$req->month,'year'=>$req->year,'databymonthcount'=>$databymonthcount]);
        }
        $minmonthyear = DB::select('SELECT MIN(YEAR(date)) as min_year ,MAX(YEAR(date)) as max_year FROM expenditure');
        return view('reports/bymonth', ['minmonthyear'=>$minmonthyear]);
    }
    public function bymonthexp(Request $req)
    {
        if(isset($_POST['submit']))
        {
            $exp_type = ExpType::get('exp_type');
            $minmonthyear = DB::select('SELECT MIN(YEAR(date)) as min_year ,MAX(YEAR(date)) as max_year FROM expenditure');
            $databymonthcount = DB::select('SELECT COUNT(*) AS month_count FROM `expenditure` where MONTH(date)='.$req->month.' AND YEAR(date)='.$req->year);
            $getdatebymonthyear = DB::select("SELECT DISTINCT(date) FROM `expenditure`where MONTH(date)=$req->month AND YEAR(date)=$req->year ORDER BY date");
            return view('reports/bymonthexp', ['exp_type'=>$exp_type,'getdatebymonthyear'=>$getdatebymonthyear,'month'=>$req->month,'year'=>$req->year,'minmonthyear'=>$minmonthyear,'databymonthcount'=>$databymonthcount,]);
        }
        $minmonthyear = DB::select('SELECT MIN(YEAR(date)) as min_year ,MAX(YEAR(date)) as max_year FROM expenditure');
        return view('reports/bymonthexp', ['minmonthyear'=>$minmonthyear]);
    }
    
}
