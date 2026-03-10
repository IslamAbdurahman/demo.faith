<?php

namespace App\Http\Controllers;

use App\Exports\SalaryExport;
use App\Http\Requests\SalaryStoreRequest;
use App\Models\Kassa;
use App\Models\Salary;
use App\Models\Sms;
use App\Models\SmsService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function export(Request $request)
    {
        $salary = new SalaryExport();
        $salary->from = $request->from;
        $salary->to = $request->to;
        $salary->search = $request->search;
        return Excel::download($salary, date("Y-m-d H:i:s").'-results.xlsx');
    }

    public function index(Request $request)
    {
        if ($request->per_page){
            $per_page = $request->per_page;
        }else{
            $per_page = 10;
        }
        if ($request->search && $request->from && $request->to){
            $search = $request->search;
            $from = $request->from;
            $to = $request->to;
            $salaries = DB::table('salaries as s')
                ->leftJoin('users as w','w.id','=','s.worker_id')
                ->leftJoin('users as u','u.id','=','s.user_id')
                ->leftJoin('kassa as k','k.id','=','s.kassa_id')
                ->select('s.*','w.name as worker','u.name as user','k.name as kassa')
                ->where('w.name','like', '%'.$request->search.'%')
                ->whereBetween('s.date', [$request->from,$request->to.' 23:59:59'])
                ->orderBy('s.date','desc')
                ->paginate($per_page);
        }elseif ($request->from && $request->to){
            $search = '';
            $from = $request->from;
            $to = $request->to;
            $salaries = DB::table('salaries as s')
                ->leftJoin('users as w','w.id','=','s.worker_id')
                ->leftJoin('users as u','u.id','=','s.user_id')
                ->leftJoin('kassa as k','k.id','=','s.kassa_id')
                ->select('s.*','w.name as worker','u.name as user','k.name as kassa')
                ->whereBetween('s.date', [$request->from,$request->to.' 23:59:59'])
                ->orderBy('s.date','desc')
                ->paginate($per_page);
        }elseif ($request->search){
            $search = $request->search;
            $from = '';
            $to = '';
            $salaries = DB::table('salaries as s')
                ->leftJoin('users as w','w.id','=','s.worker_id')
                ->leftJoin('users as u','u.id','=','s.user_id')
                ->leftJoin('kassa as k','k.id','=','s.kassa_id')
                ->select('s.*','w.name as worker','u.name as user','k.name as kassa')
                ->where('w.name','like', '%'.$request->search.'%')
                ->orderBy('s.date','desc')
                ->paginate($per_page);
        }else {
            $search = '';
            $from = '';
            $to = '';
            $salaries = DB::table('salaries as s')
                ->leftJoin('users as w','w.id','=','s.worker_id')
                ->leftJoin('users as u','u.id','=','s.user_id')
                ->leftJoin('kassa as k','k.id','=','s.kassa_id')
                ->orderBy('s.date','desc')
                ->select('s.*','w.name as worker','u.name as user','k.name as kassa')
                ->paginate($per_page);
        }


        $workers = DB::table('users as u')
                    ->join('roles as r','r.id','=','u.role')
                ->select('u.*','r.name as role_as')
                ->get();
        $kassas = Kassa::all();

        return view('admin.salaries.index',compact(
            'salaries','search','per_page','workers','kassas','from','to'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalaryStoreRequest $request)
    {
        $kassa = Kassa::find($request->kassa_id);
        if ($kassa->balance < $request->amount){
            return redirect()->back()->withErrors([
                'error'=>__('lang.kassa_error'),
            ]);
        }

        $worker = User::find($request->worker_id);
        if ($worker->role == 4){
            if ($worker->balance < $request->amount){
                return redirect()->back()->withErrors([
                    "error"=>__('lang.teacher_balance_error'),
                ]);
            }
        }

        $date =  \Illuminate\Support\Carbon::now()->setTimezone('Asia/Tashkent')->format('Y-m-d H:i:s');

        $salary = new Salary();
        $salary->personal = $request->personal;
        $salary->worker_id = $request->worker_id;
        $salary->amount = $request->amount;
        $salary->user_id = Auth::user()->id;
        $salary->kassa_id = $request->kassa_id;
        $salary->date = $date;
        $salary->comment = $request->comment;
        $salary->save();

        $sms = SmsService::send_sms($worker->phone,Auth::user()->name." : ".$worker->name."ga ".$date." da ".$request->amount." so'm berildi" );


        return redirect()->back()->withErrors([
            'success'=>__('lang.saved'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function show(Salary $salary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function edit(Salary $salary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Salary $salary)
    {
    //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Salary $salary)
    {

        $salary->delete();

        return redirect()->back()->withErrors([
            'success'=>__('lang.deleted'),
        ]);
    }
}
