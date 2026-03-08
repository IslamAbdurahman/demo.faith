<?php

namespace App\Http\Controllers;

use App\Exports\PaymentExport;
use App\Models\Graphic;
use App\Models\Group;
use App\Models\Kassa;
use App\Models\Payment;
use App\Models\Sms;
use App\Models\SmsService;
use App\Models\Students;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function payment_check($id){

        $payment = DB::table('payments as p')
            ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
            ->join('groups as g','g.id','=','gr.group_id')
            ->join('users as t','t.id','=','g.teacher_id')
            ->join('kassa as k','k.id','=','p.kassa_id')
            ->join('students as s','s.id','=','p.student_id')
            ->select('p.*','s.name as student','g.name as group',
                't.name as teacher','k.name as kassa')
            ->where('p.id','=',$id)
            ->first();

        if (!$payment){
            return redirect()->to('https://faith.uz');
        }

        return view('admin.payments.payment_check',compact('payment'));
    }


    public function export(Request $request)
    {

        $salary = new PaymentExport();
        $salary->from = $request->from;
        $salary->to = $request->to;
        $salary->search = $request->search;
        $salary->student_id = $request->student_id;
        $salary->group_id = $request->group_id;
        $salary->teacher_id = $request->teacher_id;
        return Excel::download($salary, date("Y-m-d H:i:s").'-payment.xlsx');
    }

    public function index(Request $request)
    {
        if ($request->per_page){
            $per_page = $request->per_page;
        }else{
            $per_page = 10;
        }

        if (Auth::user()->role == 1 || Auth::user()->role ==2){

        if ($request->search && $request->student_id && $request->group_id && $request->teacher_id && $request->from && $request->to){
            $from = $request->from;
            $to = $request->to;
            $search = $request->search;
            $student_id = $request->student_id;
            $teacher_id = $request->group_id;
            $group_id = $request->teacher_id;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.*','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->where('s.name','like', '%'.$request->search.'%')
                ->whereBetween('p.date',[$request->from,$request->to.' 23:59:59'])
                ->where('s.id','=',$request->student_id)
                ->where('g.id','=',$request->group_id)
                ->where('t.id','=',$request->teacher_id)
                ->orderBy('p.date','desc')
                ->paginate($per_page);
        }elseif ($request->search && $request->student_id && $request->group_id && $request->teacher_id){
            $from = '';
            $to = '';
            $search = $request->search;
            $student_id = $request->student_id;
            $teacher_id = $request->group_id;
            $group_id = $request->teacher_id;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.*','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->where('s.name','like', '%'.$request->search.'%')
                ->where('s.id','=',$request->student_id)
                ->where('g.id','=',$request->group_id)
                ->where('t.id','=',$request->teacher_id)
                ->orderBy('p.date','desc')
                ->paginate($per_page);
        }elseif ($request->student_id && $request->group_id && $request->teacher_id && $request->from && $request->to){
            $from = $request->from;
            $to = $request->to;
            $search = '';
            $student_id = $request->student_id;
            $teacher_id = $request->teacher_id;
            $group_id = $request->group_id;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.*','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->whereBetween('p.date',[$request->from,$request->to.' 23:59:59'])
                ->where('s.id','=',$request->student_id)
                ->where('g.id','=',$request->group_id)
                ->where('t.id','=',$request->teacher_id)
                ->orderBy('p.date','desc')
                ->paginate($per_page);
        }elseif ($request->student_id && $request->group_id && $request->teacher_id ){
            $from = '';
            $to = '';
            $search = '';
            $student_id = $request->student_id;
            $teacher_id = $request->teacher_id;
            $group_id = $request->group_id;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.*','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->where('s.id','=',$request->student_id)
                ->where('g.id','=',$request->group_id)
                ->where('t.id','=',$request->teacher_id)
                ->orderBy('p.date','desc')
                ->paginate($per_page);
        }elseif ($request->student_id && $request->group_id && $request->from && $request->to){
            $from = $request->from;
            $to = $request->to;
            $search = '';
            $student_id = $request->student_id;
            $group_id = $request->group_id;
            $teacher_id = 0;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.*','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->whereBetween('p.date',[$request->from,$request->to.' 23:59:59'])
                ->where('s.id','=',$request->student_id)
                ->where('g.id','=',$request->group_id)
                ->orderBy('p.date','desc')
                ->paginate($per_page);
        }elseif ($request->student_id && $request->group_id ){
            $from = '';
            $to = '';
            $search = '';
            $student_id = $request->student_id;
            $group_id = $request->group_id;
            $teacher_id = 0;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.*','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->where('s.id','=',$request->student_id)
                ->where('g.id','=',$request->group_id)
                ->orderBy('p.date','desc')
                ->paginate($per_page);
        }elseif ($request->student_id && $request->teacher_id && $request->from && $request->to){
            $from = $request->from;
            $to = $request->to;
            $search = '';
            $student_id = $request->student_id;
            $teacher_id = $request->teacher_id;
            $group_id = 0;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.*','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->whereBetween('p.date',[$request->from,$request->to.' 23:59:59'])
                ->where('s.id','=',$request->student_id)
                ->where('t.id','=',$request->teacher_id)
                ->orderBy('p.date','desc')
                ->paginate($per_page);
        }elseif ($request->student_id && $request->teacher_id ){
            $from = '';
            $to = '';
            $search = '';
            $student_id = $request->student_id;
            $teacher_id = $request->teacher_id;
            $group_id = 0;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.*','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->where('s.id','=',$request->student_id)
                ->where('t.id','=',$request->teacher_id)
                ->orderBy('p.date','desc')
                ->paginate($per_page);
        }elseif ($request->group_id && $request->teacher_id && $request->from && $request->to){
            $from = $request->from;
            $to = $request->to;
            $search = '';
            $student_id = 0;
            $teacher_id = $request->teacher_id;
            $group_id = $request->group_id;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.*','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->whereBetween('p.date',[$request->from,$request->to.' 23:59:59'])
                ->where('s.id','=',$request->student_id)
                ->where('g.id','=',$request->group_id)
                ->where('t.id','=',$request->teacher_id)
                ->orderBy('p.date','desc')
                ->paginate($per_page);
        }elseif ($request->group_id && $request->teacher_id ){
            $from = '';
            $to = '';
            $search = '';
            $student_id = 0;
            $teacher_id = $request->teacher_id;
            $group_id = $request->group_id;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.*','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->where('g.id','=',$request->group_id)
                ->where('t.id','=',$request->teacher_id)
                ->orderBy('p.date','desc')
                ->paginate($per_page);
        }elseif ($request->search && $request->from && $request->to){
            $from = $request->from;
            $to = $request->to;
            $search = $request->search;
            $student_id = 0;
            $teacher_id = 0;
            $group_id = 0;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.*','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->whereBetween('p.date',[$request->from,$request->to.' 23:59:59'])
                ->where('s.name','like', '%'.$request->search.'%')
                ->orderBy('p.date','desc')
                ->paginate($per_page);
        }elseif ($request->search){
            $from = '';
            $to = '';
            $search = $request->search;
            $student_id = 0;
            $teacher_id = 0;
            $group_id = 0;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.*','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->where('s.name','like', '%'.$request->search.'%')
                ->orderBy('p.date','desc')
                ->paginate($per_page);
        }elseif ($request->student_id && $request->from && $request->to){
            $from = $request->from;
            $to = $request->to;
            $search = '';
            $student_id = $request->student_id;
            $teacher_id = 0;
            $group_id = 0;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.*','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->whereBetween('p.date',[$request->from,$request->to.' 23:59:59'])
                ->where('s.id','=',$request->student_id)
                ->orderBy('p.date','desc')
                ->paginate($per_page);
        }elseif ($request->student_id ){
            $from = '';
            $to = '';
            $search = '';
            $student_id = $request->student_id;
            $teacher_id = 0;
            $group_id = 0;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.*','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->where('s.id','=',$request->student_id)
                ->orderBy('p.date','desc')
                ->paginate($per_page);
        }elseif ($request->group_id && $request->from && $request->to){
            $from = $request->from;
            $to = $request->to;
            $search = '';
            $student_id = 0;
            $group_id = $request->group_id;
            $teacher_id = 0;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.*','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->whereBetween('p.date',[$request->from,$request->to.' 23:59:59'])
                ->where('g.id','=',$request->group_id)
                ->orderBy('p.date','desc')
                ->paginate($per_page);
        }elseif ($request->group_id){
            $from = '';
            $to = '';
            $search = '';
            $student_id = 0;
            $group_id = $request->group_id;
            $teacher_id = 0;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.*','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->where('g.id','=',$request->group_id)
                ->orderBy('p.date','desc')
                ->paginate($per_page);
        }elseif ($request->teacher_id && $request->from && $request->to){
            $from = $request->from;
            $to = $request->to;
            $search = '';
            $student_id = 0;
            $group_id = 0;
            $teacher_id = $request->teacher_id;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.*','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->whereBetween('p.date',[$request->from,$request->to.' 23:59:59'])
                ->where('t.id','=',$request->teacher_id)
                ->orderBy('p.date','desc')
                ->paginate($per_page);
        }elseif ($request->teacher_id ){
            $from = '';
            $to = '';
            $search = '';
            $student_id = 0;
            $group_id = 0;
            $teacher_id = $request->teacher_id;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.*','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->where('t.id','=',$request->teacher_id)
                ->orderBy('p.date','desc')
                ->paginate($per_page);
        }elseif ($request->from && $request->to){
            $from = $request->from;
            $to = $request->to;
            $search = '';
            $student_id = 0;
            $group_id = 0;
            $teacher_id = 0;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.*','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->whereBetween('p.date',[$request->from,$request->to.' 23:59:59'])
                ->orderBy('p.date','desc')
                ->paginate($per_page);
        }else{
            $from = '';
            $to = '';
            $search = '';
            $student_id = 0;
            $group_id = 0;
            $teacher_id = 0;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.*','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->orderBy('p.date','desc')
                ->paginate($per_page);
        }

        }else{

            if ($request->search && $request->student_id && $request->group_id && $request->teacher_id && $request->from && $request->to){
                $search = $request->search;
                $student_id = $request->student_id;
                $teacher_id = $request->group_id;
                $group_id = $request->teacher_id;
                $payments = DB::table('payments as p')
                    ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                    ->join('groups as g','g.id','=','gr.group_id')
                    ->join('users as t','t.id','=','g.teacher_id')
                    ->join('kassa as k','k.id','=','p.kassa_id')
                    ->join('students as s','s.id','=','p.student_id')
                    ->select('p.*','s.name as student','g.name as group',
                        't.name as teacher','k.name as kassa')
                    ->where('g.teacher_id','=',Auth::user()->id)
                    ->whereBetween('p.date',[$request->from,$request->to.' 23:59:59'])
                    ->where('s.name','like', '%'.$request->search.'%')
                    ->where('s.id','=',$request->student_id)
                    ->where('g.id','=',$request->group_id)
                    ->where('t.id','=',$request->teacher_id)
                    ->orderBy('p.date','desc')
                    ->paginate($per_page);
            }elseif ($request->search && $request->student_id && $request->group_id && $request->teacher_id ){
                $search = $request->search;
                $student_id = $request->student_id;
                $teacher_id = $request->group_id;
                $group_id = $request->teacher_id;
                $payments = DB::table('payments as p')
                    ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                    ->join('groups as g','g.id','=','gr.group_id')
                    ->join('users as t','t.id','=','g.teacher_id')
                    ->join('kassa as k','k.id','=','p.kassa_id')
                    ->join('students as s','s.id','=','p.student_id')
                    ->select('p.*','s.name as student','g.name as group',
                        't.name as teacher','k.name as kassa')
                    ->where('g.teacher_id','=',Auth::user()->id)
                    ->where('s.name','like', '%'.$request->search.'%')
                    ->where('s.id','=',$request->student_id)
                    ->where('g.id','=',$request->group_id)
                    ->where('t.id','=',$request->teacher_id)
                    ->orderBy('p.date','desc')
                    ->paginate($per_page);
            }elseif ($request->student_id && $request->group_id && $request->teacher_id && $request->from && $request->to){
                $search = '';
                $student_id = $request->student_id;
                $teacher_id = $request->teacher_id;
                $group_id = $request->group_id;
                $payments = DB::table('payments as p')
                    ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                    ->join('groups as g','g.id','=','gr.group_id')
                    ->join('users as t','t.id','=','g.teacher_id')
                    ->join('kassa as k','k.id','=','p.kassa_id')
                    ->join('students as s','s.id','=','p.student_id')
                    ->select('p.*','s.name as student','g.name as group',
                        't.name as teacher','k.name as kassa')
                    ->where('g.teacher_id','=',Auth::user()->id)
                    ->whereBetween('p.date',[$request->from,$request->to.' 23:59:59'])
                    ->where('s.id','=',$request->student_id)
                    ->where('g.id','=',$request->group_id)
                    ->where('t.id','=',$request->teacher_id)
                    ->orderBy('p.date','desc')
                    ->paginate($per_page);
            }elseif ($request->student_id && $request->group_id && $request->teacher_id ){
                $search = '';
                $student_id = $request->student_id;
                $teacher_id = $request->teacher_id;
                $group_id = $request->group_id;
                $payments = DB::table('payments as p')
                    ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                    ->join('groups as g','g.id','=','gr.group_id')
                    ->join('users as t','t.id','=','g.teacher_id')
                    ->join('kassa as k','k.id','=','p.kassa_id')
                    ->join('students as s','s.id','=','p.student_id')
                    ->select('p.*','s.name as student','g.name as group',
                        't.name as teacher','k.name as kassa')
                    ->where('g.teacher_id','=',Auth::user()->id)
                    ->where('s.id','=',$request->student_id)
                    ->where('g.id','=',$request->group_id)
                    ->where('t.id','=',$request->teacher_id)
                    ->orderBy('p.date','desc')
                    ->paginate($per_page);
            }elseif ($request->student_id && $request->group_id && $request->from && $request->to){
                $search = '';
                $student_id = $request->student_id;
                $group_id = $request->group_id;
                $teacher_id = 0;
                $payments = DB::table('payments as p')
                    ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                    ->join('groups as g','g.id','=','gr.group_id')
                    ->join('users as t','t.id','=','g.teacher_id')
                    ->join('kassa as k','k.id','=','p.kassa_id')
                    ->join('students as s','s.id','=','p.student_id')
                    ->select('p.*','s.name as student','g.name as group',
                        't.name as teacher','k.name as kassa')
                    ->where('g.teacher_id','=',Auth::user()->id)
                    ->whereBetween('p.date',[$request->from,$request->to.' 23:59:59'])
                    ->where('s.id','=',$request->student_id)
                    ->where('g.id','=',$request->group_id)
                    ->orderBy('p.date','desc')
                    ->paginate($per_page);
            }elseif ($request->student_id && $request->group_id ){
                $search = '';
                $student_id = $request->student_id;
                $group_id = $request->group_id;
                $teacher_id = 0;
                $payments = DB::table('payments as p')
                    ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                    ->join('groups as g','g.id','=','gr.group_id')
                    ->join('users as t','t.id','=','g.teacher_id')
                    ->join('kassa as k','k.id','=','p.kassa_id')
                    ->join('students as s','s.id','=','p.student_id')
                    ->select('p.*','s.name as student','g.name as group',
                        't.name as teacher','k.name as kassa')
                    ->where('g.teacher_id','=',Auth::user()->id)
                    ->where('s.id','=',$request->student_id)
                    ->where('g.id','=',$request->group_id)
                    ->orderBy('p.date','desc')
                    ->paginate($per_page);
            }elseif ($request->student_id && $request->teacher_id && $request->from && $request->to){
                $search = '';
                $student_id = $request->student_id;
                $teacher_id = $request->teacher_id;
                $group_id = 0;
                $payments = DB::table('payments as p')
                    ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                    ->join('groups as g','g.id','=','gr.group_id')
                    ->join('users as t','t.id','=','g.teacher_id')
                    ->join('kassa as k','k.id','=','p.kassa_id')
                    ->join('students as s','s.id','=','p.student_id')
                    ->select('p.*','s.name as student','g.name as group',
                        't.name as teacher','k.name as kassa')
                    ->where('g.teacher_id','=',Auth::user()->id)
                    ->whereBetween('p.date',[$request->from,$request->to.' 23:59:59'])
                    ->where('s.id','=',$request->student_id)
                    ->where('t.id','=',$request->teacher_id)
                    ->orderBy('p.date','desc')
                    ->paginate($per_page);
            }elseif ($request->student_id && $request->teacher_id ){
                $search = '';
                $student_id = $request->student_id;
                $teacher_id = $request->teacher_id;
                $group_id = 0;
                $payments = DB::table('payments as p')
                    ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                    ->join('groups as g','g.id','=','gr.group_id')
                    ->join('users as t','t.id','=','g.teacher_id')
                    ->join('kassa as k','k.id','=','p.kassa_id')
                    ->join('students as s','s.id','=','p.student_id')
                    ->select('p.*','s.name as student','g.name as group',
                        't.name as teacher','k.name as kassa')
                    ->where('g.teacher_id','=',Auth::user()->id)
                    ->where('s.id','=',$request->student_id)
                    ->where('t.id','=',$request->teacher_id)
                    ->orderBy('p.date','desc')
                    ->paginate($per_page);
            }elseif ($request->group_id && $request->teacher_id && $request->from && $request->to){
                $search = '';
                $student_id = 0;
                $teacher_id = $request->teacher_id;
                $group_id = $request->group_id;
                $payments = DB::table('payments as p')
                    ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                    ->join('groups as g','g.id','=','gr.group_id')
                    ->join('users as t','t.id','=','g.teacher_id')
                    ->join('kassa as k','k.id','=','p.kassa_id')
                    ->join('students as s','s.id','=','p.student_id')
                    ->select('p.*','s.name as student','g.name as group',
                        't.name as teacher','k.name as kassa')
                    ->where('g.teacher_id','=',Auth::user()->id)
                    ->whereBetween('p.date',[$request->from,$request->to.' 23:59:59'])
                    ->where('s.id','=',$request->student_id)
                    ->where('g.id','=',$request->group_id)
                    ->where('t.id','=',$request->teacher_id)
                    ->orderBy('p.date','desc')
                    ->paginate($per_page);
            }elseif ($request->group_id && $request->teacher_id ){
                $search = '';
                $student_id = 0;
                $teacher_id = $request->teacher_id;
                $group_id = $request->group_id;
                $payments = DB::table('payments as p')
                    ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                    ->join('groups as g','g.id','=','gr.group_id')
                    ->join('users as t','t.id','=','g.teacher_id')
                    ->join('kassa as k','k.id','=','p.kassa_id')
                    ->join('students as s','s.id','=','p.student_id')
                    ->select('p.*','s.name as student','g.name as group',
                        't.name as teacher','k.name as kassa')
                    ->where('g.teacher_id','=',Auth::user()->id)
                    ->where('g.id','=',$request->group_id)
                    ->where('t.id','=',$request->teacher_id)
                    ->orderBy('p.date','desc')
                    ->paginate($per_page);
            }elseif ($request->search && $request->from && $request->to){
                $search = $request->search;
                $student_id = 0;
                $teacher_id = 0;
                $group_id = 0;
                $payments = DB::table('payments as p')
                    ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                    ->join('groups as g','g.id','=','gr.group_id')
                    ->join('users as t','t.id','=','g.teacher_id')
                    ->join('kassa as k','k.id','=','p.kassa_id')
                    ->join('students as s','s.id','=','p.student_id')
                    ->select('p.*','s.name as student','g.name as group',
                        't.name as teacher','k.name as kassa')
                    ->where('g.teacher_id','=',Auth::user()->id)
                    ->whereBetween('p.date',[$request->from,$request->to.' 23:59:59'])
                    ->where('s.name','like', '%'.$request->search.'%')
                    ->orderBy('p.date','desc')
                    ->paginate($per_page);
            }elseif ($request->search){
                $search = $request->search;
                $student_id = 0;
                $teacher_id = 0;
                $group_id = 0;
                $payments = DB::table('payments as p')
                    ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                    ->join('groups as g','g.id','=','gr.group_id')
                    ->join('users as t','t.id','=','g.teacher_id')
                    ->join('kassa as k','k.id','=','p.kassa_id')
                    ->join('students as s','s.id','=','p.student_id')
                    ->select('p.*','s.name as student','g.name as group',
                        't.name as teacher','k.name as kassa')
                    ->where('g.teacher_id','=',Auth::user()->id)
                    ->where('s.name','like', '%'.$request->search.'%')
                    ->orderBy('p.date','desc')
                    ->paginate($per_page);
            }elseif ($request->student_id && $request->from && $request->to){
                $search = '';
                $student_id = $request->student_id;
                $teacher_id = 0;
                $group_id = 0;
                $payments = DB::table('payments as p')
                    ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                    ->join('groups as g','g.id','=','gr.group_id')
                    ->join('users as t','t.id','=','g.teacher_id')
                    ->join('kassa as k','k.id','=','p.kassa_id')
                    ->join('students as s','s.id','=','p.student_id')
                    ->select('p.*','s.name as student','g.name as group',
                        't.name as teacher','k.name as kassa')
                    ->where('g.teacher_id','=',Auth::user()->id)
                    ->whereBetween('p.date',[$request->from,$request->to.' 23:59:59'])
                    ->where('s.id','=',$request->student_id)
                    ->orderBy('p.date','desc')
                    ->paginate($per_page);
            }elseif ($request->student_id ){
                $search = '';
                $student_id = $request->student_id;
                $teacher_id = 0;
                $group_id = 0;
                $payments = DB::table('payments as p')
                    ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                    ->join('groups as g','g.id','=','gr.group_id')
                    ->join('users as t','t.id','=','g.teacher_id')
                    ->join('kassa as k','k.id','=','p.kassa_id')
                    ->join('students as s','s.id','=','p.student_id')
                    ->select('p.*','s.name as student','g.name as group',
                        't.name as teacher','k.name as kassa')
                    ->where('g.teacher_id','=',Auth::user()->id)
                    ->where('s.id','=',$request->student_id)
                    ->orderBy('p.date','desc')
                    ->paginate($per_page);
            }elseif ($request->group_id && $request->from && $request->to){
                $search = '';
                $student_id = 0;
                $group_id = $request->group_id;
                $teacher_id = 0;
                $payments = DB::table('payments as p')
                    ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                    ->join('groups as g','g.id','=','gr.group_id')
                    ->join('users as t','t.id','=','g.teacher_id')
                    ->join('kassa as k','k.id','=','p.kassa_id')
                    ->join('students as s','s.id','=','p.student_id')
                    ->select('p.*','s.name as student','g.name as group',
                        't.name as teacher','k.name as kassa')
                    ->where('g.teacher_id','=',Auth::user()->id)
                    ->where('g.id','=',$request->group_id)
                    ->whereBetween('p.date',[$request->from,$request->to.' 23:59:59'])
                    ->orderBy('p.date','desc')
                    ->paginate($per_page);
            }elseif ($request->group_id){
                $search = '';
                $student_id = 0;
                $group_id = $request->group_id;
                $teacher_id = 0;
                $payments = DB::table('payments as p')
                    ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                    ->join('groups as g','g.id','=','gr.group_id')
                    ->join('users as t','t.id','=','g.teacher_id')
                    ->join('kassa as k','k.id','=','p.kassa_id')
                    ->join('students as s','s.id','=','p.student_id')
                    ->select('p.*','s.name as student','g.name as group',
                        't.name as teacher','k.name as kassa')
                    ->where('g.teacher_id','=',Auth::user()->id)
                    ->where('g.id','=',$request->group_id)
                    ->orderBy('p.date','desc')
                    ->paginate($per_page);
            }elseif ($request->teacher_id && $request->from && $request->to){
                $search = '';
                $student_id = 0;
                $group_id = 0;
                $teacher_id = $request->teacher_id;
                $payments = DB::table('payments as p')
                    ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                    ->join('groups as g','g.id','=','gr.group_id')
                    ->join('users as t','t.id','=','g.teacher_id')
                    ->join('kassa as k','k.id','=','p.kassa_id')
                    ->join('students as s','s.id','=','p.student_id')
                    ->select('p.*','s.name as student','g.name as group',
                        't.name as teacher','k.name as kassa')
                    ->where('g.teacher_id','=',Auth::user()->id)
                    ->whereBetween('p.date',[$request->from,$request->to.' 23:59:59'])
                    ->where('t.id','=',$request->teacher_id)
                    ->orderBy('p.date','desc')
                    ->paginate($per_page);
            }elseif ($request->teacher_id ){
                $search = '';
                $student_id = 0;
                $group_id = 0;
                $teacher_id = $request->teacher_id;
                $payments = DB::table('payments as p')
                    ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                    ->join('groups as g','g.id','=','gr.group_id')
                    ->join('users as t','t.id','=','g.teacher_id')
                    ->join('kassa as k','k.id','=','p.kassa_id')
                    ->join('students as s','s.id','=','p.student_id')
                    ->select('p.*','s.name as student','g.name as group',
                        't.name as teacher','k.name as kassa')
                    ->where('g.teacher_id','=',Auth::user()->id)
                    ->where('t.id','=',$request->teacher_id)
                    ->orderBy('p.date','desc')
                    ->paginate($per_page);
            }elseif ($request->from && $request->to){
                $search = '';
                $student_id = 0;
                $group_id = 0;
                $teacher_id = $request->teacher_id;
                $payments = DB::table('payments as p')
                    ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                    ->join('groups as g','g.id','=','gr.group_id')
                    ->join('users as t','t.id','=','g.teacher_id')
                    ->join('kassa as k','k.id','=','p.kassa_id')
                    ->join('students as s','s.id','=','p.student_id')
                    ->select('p.*','s.name as student','g.name as group',
                        't.name as teacher','k.name as kassa')
                    ->where('g.teacher_id','=',Auth::user()->id)
                    ->whereBetween('p.date',[$request->from,$request->to.' 23:59:59'])
                    ->orderBy('p.date','desc')
                    ->paginate($per_page);
            }else{
                $search = '';
                $student_id = 0;
                $group_id = 0;
                $teacher_id = 0;
                $payments = DB::table('payments as p')
                    ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                    ->join('groups as g','g.id','=','gr.group_id')
                    ->join('users as t','t.id','=','g.teacher_id')
                    ->join('kassa as k','k.id','=','p.kassa_id')
                    ->join('students as s','s.id','=','p.student_id')
                    ->select('p.*','s.name as student','g.name as group',
                        't.name as teacher','k.name as kassa')
                    ->where('g.teacher_id','=',Auth::user()->id)
                    ->orderBy('p.date','desc')
                    ->paginate($per_page);
            }
        }

        if ($request->from && $request->to){
            $from = $request->from;
            $to = $request->to;
        }else{
            $from = '';
            $to = '';
        }

        $students = Students::all();
        $teachers = User::where('role','=',4)->get();
        $kassas = Kassa::all();
        if (Auth::user()->role == 1 || Auth::user()->role ==2) {
            $groups = Group::all();
        }else{
            $groups = Group::where('teacher_id',Auth::user()->id)->get();
        }
        $graphics = DB::table('graphics as gr')
            ->join('students as s','s.id','=','gr.student_id')
            ->join('groups as g','g.id','=','gr.group_id')
            ->select('gr.*','s.name as student','g.name as group')
            ->where('gr.remaining_amount','>',0)
            ->groupBy('gr.id')
            ->orderBy('gr.month','asc')
            ->get();

        Carbon::setLocale(__('lang.date_zone'));


        return view('admin.payments.index',compact(
            'payments','search','per_page',
            'students','teachers','groups',
            'kassas','graphics',
            'student_id','teacher_id','group_id',
            'from','to'
        ));
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
    public function store(Request $request)
    {
        $request->validate([
            'kassa_id'=>'required',
            'graphic_id'=>'required',
            'amount'=>'required',
            'discount'=>'required',
        ]);

        $kassa = Kassa::find($request->kassa_id);
        $graphic = Graphic::find($request->graphic_id);


        if ($request->amount > $graphic->remaining_amount){
            return redirect()->back()->withErrors([
                'error'=>'Amount more than remaining amount',
            ]);
        }

        if ($kassa->is_click == 1){
            return redirect()->route('click',['click',$graphic->id,$request->amount]);
        }

        if ($request->discount > 0){
            $graphic->amount = $graphic->amount-$request->discount;
            $graphic->remaining_amount = $graphic->remaining_amount-$request->discount;
            $graphic->update();
        }

        $payment = new Payment();
        $payment->month = $graphic->month;
        $payment->amount = $request->amount;
        $payment->discount = $request->discount;
        $payment->kitchen = $graphic->kitchen;
        $payment->bedroom = $graphic->bedroom;
        $payment->education = $graphic->education;
        $payment->comment = $request->comment;
        $payment->user_id = Auth::user()->id;
        $payment->student_id = $graphic->student_id;
        $payment->graphic_id = $graphic->id;
        $payment->kassa_id = $kassa->id;
        $payment->date = tash_time();
        $payment->save();

        $student = Students::find($graphic->student_id);
        $group = Group::find($graphic->group_id);

        $sms_parent = SmsService::send_sms(
            $student->parent_phone,
            Auth::user()->name." : "."Student: ".$student->name.". Sana: ".$payment->date.
            ". Guruh: ".$group->name." To'lov summa: ".$request->amount
        );

        $sms = SmsService::send_sms(
            $student->phone,
            Auth::user()->name." : "."Student: ".$student->name.". Sana: ".$payment->date.
            ". Guruh: ".$group->name." To'lov summa: ".$request->amount
        );

        Sms::create([
            'student_id'=>$student->id,
            'user_id'=> Auth::user()->id,
            'text'=> Auth::user()->name." : "."Student: ".$student->name.". Sana: ".$payment->date.
                ". Guruh: ".$group->name." To'lov summa: ".$request->amount." so'm",
            'date'=>tash_time(),
            'service_id'=>$sms->service_id,
            'status'=>$sms->status
        ]);

        return redirect()->back()->withErrors([
            'success'=>__('lang.saved'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
       //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        try {
            $payment->delete();

            return redirect()->back()->withErrors([
                'success'=>__('lang.deleted'),
            ]);
        }catch (\Exception $exception){
            return redirect()->back()->withErrors([
                'error'=>__('lang.cannot_delete'),
            ]);
        }


    }

    public function handle($paysys)
    {
        (new \Goodoneuz\PayUz\PayUz)->driver($paysys)->handle();
    }

    public function redirect($paysys, $key, $amount)
    {
        $model = \Goodoneuz\PayUz\Services\PaymentService::convertKeyToModel($key);
        $url = request('redirect_url', '/'); // redirect url after payment completed
        $pay_uz = new \Goodoneuz\PayUz\PayUz;
        $pay_uz->driver($paysys)->redirect($model, $amount, 860, $url);
    }
}
