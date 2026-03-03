<?php

namespace App\Exports;

use App\Models\Salary;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class SalaryExport implements FromCollection
{
    public $from;
    public $to;
    public $search;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        if ($this->search && $this->from && $this->to){
            $salaries = DB::table('salaries as s')
                ->leftJoin('users as w','w.id','=','s.worker_id')
                ->leftJoin('users as u','u.id','=','s.user_id')
                ->leftJoin('kassa as k','k.id','=','s.kassa_id')
                ->select('s.id','s.personal','s.amount','s.date','s.comment',
                    'w.name as worker','u.name as user','k.name as kassa')
                ->where('w.name','like', '%'.$this->search.'%')
                ->whereBetween('s.date', [$this->from,$this->to.' 23:59:59'])
                ->orderBy('s.date','desc')
                ->get();
        }elseif ($this->from && $this->to){
            $salaries = DB::table('salaries as s')
                ->leftJoin('users as w','w.id','=','s.worker_id')
                ->leftJoin('users as u','u.id','=','s.user_id')
                ->leftJoin('kassa as k','k.id','=','s.kassa_id')
                ->select('s.id','s.personal','s.amount','s.date','s.comment',
                    'w.name as worker','u.name as user','k.name as kassa')
                ->whereBetween('s.date', [$this->from,$this->to.' 23:59:59'])
                ->orderBy('s.date','desc')
                ->get();
        }elseif ($this->search){
            $salaries = DB::table('salaries as s')
                ->leftJoin('users as w','w.id','=','s.worker_id')
                ->leftJoin('users as u','u.id','=','s.user_id')
                ->leftJoin('kassa as k','k.id','=','s.kassa_id')
                ->select('s.id','s.personal','s.amount','s.date','s.comment',
                    'w.name as worker','u.name as user','k.name as kassa')
                ->where('w.name','like', '%'.$this->search.'%')
                ->orderBy('s.date','desc')
                ->get();
        }else {
            $salaries = DB::table('salaries as s')
                ->leftJoin('users as w','w.id','=','s.worker_id')
                ->leftJoin('users as u','u.id','=','s.user_id')
                ->leftJoin('kassa as k','k.id','=','s.kassa_id')
                ->orderBy('s.date','desc')
                ->select('s.id','s.personal','s.amount','s.date','s.comment',
                    'w.name as worker','u.name as user','k.name as kassa')
                ->get();
        }

        return $salaries;
    }
}
