<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class GroupExport implements FromCollection
{


    /**
    * @return \Illuminate\Support\Collection
    */

    public $group_id;
    public $group_route;

    public function collection()
    {
        $group = $this->group_id;
        $students = DB::table('student_groups as sg')
            ->leftJoin('students as s','s.id','=','sg.student_id')
            ->leftJoin('groups as g','g.id','=','sg.group_id')
            ->leftJoin('attendances as a', function($q) use ($group)
            {
                $q->on('a.student_id', '=', 'sg.student_id')
                    ->on('a.group_id','=',DB::raw($group));
            })
            ->select('s.*','sg.id as sg_id','sg.date',
                DB::raw('count(a.id) as missed')
            )
            ->where('sg.group_id','=',$group)
            ->orderByRaw('name '.$this->group_route)
            ->groupBy('sg.id')
            ->get();

        return $students;
    }
}
