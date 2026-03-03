<?php

namespace App\Exports;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class PaymentExport implements FromCollection
{
    public $from;
    public $to;
    public $search;
    public $student_id;
    public $group_id;
    public $teacher_id;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        if ($this->search && $this->student_id && $this->group_id && $this->teacher_id && $this->from && $this->to){
            $from = $this->from;
            $to = $this->to;
            $search = $this->search;
            $student_id = $this->student_id;
            $teacher_id = $this->group_id;
            $group_id = $this->teacher_id;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.id','p.month','p.amount','p.discount','p.date','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->where('s.name','like', '%'.$this->search.'%')
                ->whereBetween('p.date',[$this->from,$this->to.' 23:59:59'])
                ->where('s.id','=',$this->student_id)
                ->where('g.id','=',$this->group_id)
                ->where('t.id','=',$this->teacher_id)
                ->orderBy('p.date','desc')
                ->get();
        }elseif ($this->search && $this->student_id && $this->group_id && $this->teacher_id){
            $from = '';
            $to = '';
            $search = $this->search;
            $student_id = $this->student_id;
            $teacher_id = $this->group_id;
            $group_id = $this->teacher_id;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.id','p.month','p.amount','p.discount','p.date','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->where('s.name','like', '%'.$this->search.'%')
                ->where('s.id','=',$this->student_id)
                ->where('g.id','=',$this->group_id)
                ->where('t.id','=',$this->teacher_id)
                ->orderBy('p.date','desc')
                ->get();
        }elseif ($this->student_id && $this->group_id && $this->teacher_id && $this->from && $this->to){
            $from = $this->from;
            $to = $this->to;
            $search = '';
            $student_id = $this->student_id;
            $teacher_id = $this->teacher_id;
            $group_id = $this->group_id;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.id','p.month','p.amount','p.discount','p.date','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->whereBetween('p.date',[$this->from,$this->to.' 23:59:59'])
                ->where('s.id','=',$this->student_id)
                ->where('g.id','=',$this->group_id)
                ->where('t.id','=',$this->teacher_id)
                ->orderBy('p.date','desc')
                ->get();
        }elseif ($this->student_id && $this->group_id && $this->teacher_id ){
            $from = '';
            $to = '';
            $search = '';
            $student_id = $this->student_id;
            $teacher_id = $this->teacher_id;
            $group_id = $this->group_id;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.id','p.month','p.amount','p.discount','p.date','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->where('s.id','=',$this->student_id)
                ->where('g.id','=',$this->group_id)
                ->where('t.id','=',$this->teacher_id)
                ->orderBy('p.date','desc')
                ->get();
        }elseif ($this->student_id && $this->group_id && $this->from && $this->to){
            $from = $this->from;
            $to = $this->to;
            $search = '';
            $student_id = $this->student_id;
            $group_id = $this->group_id;
            $teacher_id = 0;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.id','p.month','p.amount','p.discount','p.date','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->whereBetween('p.date',[$this->from,$this->to.' 23:59:59'])
                ->where('s.id','=',$this->student_id)
                ->where('g.id','=',$this->group_id)
                ->orderBy('p.date','desc')
                ->get();
        }elseif ($this->student_id && $this->group_id ){
            $from = '';
            $to = '';
            $search = '';
            $student_id = $this->student_id;
            $group_id = $this->group_id;
            $teacher_id = 0;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.id','p.month','p.amount','p.discount','p.date','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->where('s.id','=',$this->student_id)
                ->where('g.id','=',$this->group_id)
                ->orderBy('p.date','desc')
                ->get();
        }elseif ($this->student_id && $this->teacher_id && $this->from && $this->to){
            $from = $this->from;
            $to = $this->to;
            $search = '';
            $student_id = $this->student_id;
            $teacher_id = $this->teacher_id;
            $group_id = 0;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.id','p.month','p.amount','p.discount','p.date','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->whereBetween('p.date',[$this->from,$this->to.' 23:59:59'])
                ->where('s.id','=',$this->student_id)
                ->where('t.id','=',$this->teacher_id)
                ->orderBy('p.date','desc')
                ->get();
        }elseif ($this->student_id && $this->teacher_id ){
            $from = '';
            $to = '';
            $search = '';
            $student_id = $this->student_id;
            $teacher_id = $this->teacher_id;
            $group_id = 0;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.id','p.month','p.amount','p.discount','p.date','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->where('s.id','=',$this->student_id)
                ->where('t.id','=',$this->teacher_id)
                ->orderBy('p.date','desc')
                ->get();
        }elseif ($this->group_id && $this->teacher_id && $this->from && $this->to){
            $from = $this->from;
            $to = $this->to;
            $search = '';
            $student_id = 0;
            $teacher_id = $this->teacher_id;
            $group_id = $this->group_id;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.id','p.month','p.amount','p.discount','p.date','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->whereBetween('p.date',[$this->from,$this->to.' 23:59:59'])
                ->where('s.id','=',$this->student_id)
                ->where('g.id','=',$this->group_id)
                ->where('t.id','=',$this->teacher_id)
                ->orderBy('p.date','desc')
                ->get();
        }elseif ($this->group_id && $this->teacher_id ){
            $from = '';
            $to = '';
            $search = '';
            $student_id = 0;
            $teacher_id = $this->teacher_id;
            $group_id = $this->group_id;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.id','p.month','p.amount','p.discount','p.date','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->where('s.id','=',$this->student_id)
                ->where('g.id','=',$this->group_id)
                ->where('t.id','=',$this->teacher_id)
                ->orderBy('p.date','desc')
                ->get();
        }elseif ($this->search && $this->from && $this->to){
            $from = $this->from;
            $to = $this->to;
            $search = $this->search;
            $student_id = 0;
            $teacher_id = 0;
            $group_id = 0;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.id','p.month','p.amount','p.discount','p.date','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->whereBetween('p.date',[$this->from,$this->to.' 23:59:59'])
                ->where('s.name','like', '%'.$this->search.'%')
                ->orderBy('p.date','desc')
                ->get();
        }elseif ($this->search){
            $from = '';
            $to = '';
            $search = $this->search;
            $student_id = 0;
            $teacher_id = 0;
            $group_id = 0;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.id','p.month','p.amount','p.discount','p.date','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->where('s.name','like', '%'.$this->search.'%')
                ->orderBy('p.date','desc')
                ->get();
        }elseif ($this->student_id && $this->from && $this->to){
            $from = $this->from;
            $to = $this->to;
            $search = '';
            $student_id = $this->student_id;
            $teacher_id = 0;
            $group_id = 0;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.id','p.month','p.amount','p.discount','p.date','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->whereBetween('p.date',[$this->from,$this->to.' 23:59:59'])
                ->where('s.id','=',$this->student_id)
                ->orderBy('p.date','desc')
                ->get();
        }elseif ($this->student_id ){
            $from = '';
            $to = '';
            $search = '';
            $student_id = $this->student_id;
            $teacher_id = 0;
            $group_id = 0;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.id','p.month','p.amount','p.discount','p.date','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->where('s.id','=',$this->student_id)
                ->orderBy('p.date','desc')
                ->get();
        }elseif ($this->group_id && $this->from && $this->to){
            $from = $this->from;
            $to = $this->to;
            $search = '';
            $student_id = 0;
            $group_id = $this->group_id;
            $teacher_id = 0;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.id','p.month','p.amount','p.discount','p.date','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->whereBetween('p.date',[$this->from,$this->to.' 23:59:59'])
                ->where('g.id','=',$this->group_id)
                ->orderBy('p.date','desc')
                ->get();
        }elseif ($this->group_id){
            $from = '';
            $to = '';
            $search = '';
            $student_id = 0;
            $group_id = $this->group_id;
            $teacher_id = 0;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.id','p.month','p.amount','p.discount','p.date','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->where('g.id','=',$this->group_id)
                ->orderBy('p.date','desc')
                ->get();
        }elseif ($this->teacher_id && $this->from && $this->to){
            $from = $this->from;
            $to = $this->to;
            $search = '';
            $student_id = 0;
            $group_id = 0;
            $teacher_id = $this->teacher_id;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.id','p.month','p.amount','p.discount','p.date','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->whereBetween('p.date',[$this->from,$this->to.' 23:59:59'])
                ->where('t.id','=',$this->teacher_id)
                ->orderBy('p.date','desc')
                ->get();
        }elseif ($this->teacher_id ){
            $from = '';
            $to = '';
            $search = '';
            $student_id = 0;
            $group_id = 0;
            $teacher_id = $this->teacher_id;
            $payments = DB::table('payments as p')
                ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                ->join('groups as g','g.id','=','gr.group_id')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('kassa as k','k.id','=','p.kassa_id')
                ->join('students as s','s.id','=','p.student_id')
                ->select('p.id','p.month','p.amount','p.discount','p.date','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->where('t.id','=',$this->teacher_id)
                ->orderBy('p.date','desc')
                ->get();
        }elseif ($this->from && $this->to){
            $from = $this->from;
            $to = $this->to;
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
                ->select('p.id','p.month','p.amount','p.discount','p.date','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->whereBetween('p.date',[$this->from,$this->to.' 23:59:59'])
                ->orderBy('p.date','desc')
                ->get();
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
                ->select('p.id','p.month','p.amount','p.discount','p.date','s.name as student','g.name as group',
                    't.name as teacher','k.name as kassa')
                ->orderBy('p.date','desc')
                ->get();
        };

        return $payments;

    }
}
