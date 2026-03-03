<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class StudentExport implements FromCollection
{
    public $search;
    public $group;
    public $group_route;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if ($this->group_route){
            $group_route = $this->group_route;
        }else{
            $group_route = 'asc';
        }

        if ($this->search && $this->group){
            $search = $this->search;
            $group = $this->group;
            $students = DB::table('students as s')
                ->leftJoin('student_groups as g','s.id','=','g.student_id')
                ->select('s.*',DB::raw('count(g.id) as count'))
                ->where('s.name','like', '%'.$this->search.'%')
                ->orderByRaw($this->group.' '.$group_route)
                ->groupBy('s.id')
                ->get();
        }elseif ($this->search){
            $search = $this->search;
            $group = '';
            $students = DB::table('students as s')
                ->leftJoin('student_groups as g','s.id','=','g.student_id')
                ->select('s.*',DB::raw('count(g.id) as count'))
                ->where('s.name','like', '%'.$this->search.'%')
                ->orderByRaw($this->group.' '.$group_route)
                ->groupBy('s.id')
                ->get();
        }elseif ($this->group){
            $search = '';
            $group = $this->group;
            $students = DB::table('students as s')
                ->leftJoin('student_groups as g','s.id','=','g.student_id')
                ->select('s.*',DB::raw('count(g.id) as count'))
                ->groupBy('s.id')
                ->orderByRaw($this->group.' '.$group_route)
                ->get();
        }else{
            $search = '';
            $group = '';
            $students = DB::table('students as s')
                ->leftJoin('student_groups as g','s.id','=','g.student_id')
                ->select('s.*',DB::raw('count(g.id) as count'))
                ->orderByRaw('name '.$group_route)
                ->groupBy('s.id')
                ->get();
        }

        return $students;
    }
}
