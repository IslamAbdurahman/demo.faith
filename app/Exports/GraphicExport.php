<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class GraphicExport implements FromCollection
{
    public $finish;
    public $month;
    public $student_id;
    public $group_id;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        if ($this->finish) {
            $finish = $this->finish;
        } else {
            $finish = 0;
        }
        if ($this->month) {
            $month = $this->month;
        } else {
            $month = '';
        }

        if ($this->student_id && $this->group_id && $this->finish && $this->month) {
            $student_id = $this->student_id;
            $group_id = $this->group_id;
            $graphics = DB::table('graphics as gr')
                ->join('students as s', 's.id', '=', 'gr.student_id')
                ->join('groups as g', 'g.id', '=', 'gr.group_id')
                ->select('gr.id', 'gr.month', 'gr.amount', 'gr.paid_amount', 'gr.remaining_amount'
                    , 'gr.education', 'gr.kitchen', 'gr.bedroom', 's.name as student', 's.phone', 'g.name as group')
                ->where('gr.student_id', '=', $this->student_id)
                ->where('gr.group_id', '=', $this->group_id)
                ->where('gr.remaining_amount', '=', 0)
                ->where('gr.month', '=', $this->month)
                ->groupBy('gr.id')
                ->orderBy('gr.month', 'asc')
                ->get();
        } elseif ($this->student_id && $this->group_id && $this->finish) {
            $student_id = $this->student_id;
            $group_id = $this->group_id;
            $graphics = DB::table('graphics as gr')
                ->join('students as s', 's.id', '=', 'gr.student_id')
                ->join('groups as g', 'g.id', '=', 'gr.group_id')
                ->select('gr.id', 'gr.month', 'gr.amount', 'gr.paid_amount', 'gr.remaining_amount'
                    , 'gr.education', 'gr.kitchen', 'gr.bedroom', 's.name as student', 's.phone', 'g.name as group')
                ->where('gr.student_id', '=', $this->student_id)
                ->where('gr.group_id', '=', $this->group_id)
                ->where('gr.remaining_amount', '=', 0)
                ->groupBy('gr.id')
                ->orderBy('gr.month', 'asc')
                ->get();
        } elseif ($this->student_id && $this->group_id && $this->month) {
            $student_id = $this->student_id;
            $group_id = $this->group_id;
            $graphics = DB::table('graphics as gr')
                ->join('students as s', 's.id', '=', 'gr.student_id')
                ->join('groups as g', 'g.id', '=', 'gr.group_id')
                ->select('gr.id', 'gr.month', 'gr.amount', 'gr.paid_amount', 'gr.remaining_amount'
                    , 'gr.education', 'gr.kitchen', 'gr.bedroom', 's.name as student', 's.phone', 'g.name as group')
                ->where('gr.student_id', '=', $this->student_id)
                ->where('gr.group_id', '=', $this->group_id)
                ->where('gr.month', '=', $this->month)
                ->where('gr.remaining_amount', '>', 0)
                ->groupBy('gr.id')
                ->orderBy('gr.month', 'asc')
                ->get();
        } elseif ($this->student_id && $this->group_id) {
            $student_id = $this->student_id;
            $group_id = $this->group_id;
            $graphics = DB::table('graphics as gr')
                ->join('students as s', 's.id', '=', 'gr.student_id')
                ->join('groups as g', 'g.id', '=', 'gr.group_id')
                ->select('gr.id', 'gr.month', 'gr.amount', 'gr.paid_amount', 'gr.remaining_amount'
                    , 'gr.education', 'gr.kitchen', 'gr.bedroom', 's.name as student', 's.phone', 'g.name as group')
                ->where('gr.student_id', '=', $this->student_id)
                ->where('gr.group_id', '=', $this->group_id)
                ->where('gr.remaining_amount', '>', 0)
                ->groupBy('gr.id')
                ->orderBy('gr.month', 'asc')
                ->get();
        } elseif ($this->student_id && $this->finish && $this->month) {
            $student_id = $this->student_id;
            $group_id = 0;
            $graphics = DB::table('graphics as gr')
                ->join('students as s', 's.id', '=', 'gr.student_id')
                ->join('groups as g', 'g.id', '=', 'gr.group_id')
                ->select('gr.id', 'gr.month', 'gr.amount', 'gr.paid_amount', 'gr.remaining_amount'
                    , 'gr.education', 'gr.kitchen', 'gr.bedroom', 's.name as student', 's.phone', 'g.name as group')
                ->where('gr.student_id', '=', $this->student_id)
                ->where('gr.month', '=', $this->month)
                ->where('gr.remaining_amount', '=', 0)
                ->groupBy('gr.id')
                ->orderBy('gr.month', 'asc')
                ->get();
        } elseif ($this->student_id && $this->finish) {
            $student_id = $this->student_id;
            $group_id = 0;
            $graphics = DB::table('graphics as gr')
                ->join('students as s', 's.id', '=', 'gr.student_id')
                ->join('groups as g', 'g.id', '=', 'gr.group_id')
                ->select('gr.id', 'gr.month', 'gr.amount', 'gr.paid_amount', 'gr.remaining_amount'
                    , 'gr.education', 'gr.kitchen', 'gr.bedroom', 's.name as student', 's.phone', 'g.name as group')
                ->where('gr.student_id', '=', $this->student_id)
                ->where('gr.remaining_amount', '=', 0)
                ->groupBy('gr.id')
                ->orderBy('gr.month', 'asc')
                ->get();
        } elseif ($this->student_id && $this->month) {
            $student_id = $this->student_id;
            $group_id = 0;
            $graphics = DB::table('graphics as gr')
                ->join('students as s', 's.id', '=', 'gr.student_id')
                ->join('groups as g', 'g.id', '=', 'gr.group_id')
                ->select('gr.id', 'gr.month', 'gr.amount', 'gr.paid_amount', 'gr.remaining_amount'
                    , 'gr.education', 'gr.kitchen', 'gr.bedroom', 's.name as student', 's.phone', 'g.name as group')
                ->where('gr.student_id', '=', $this->student_id)
                ->where('gr.month', '=', $this->month)
                ->where('gr.remaining_amount', '>', 0)
                ->groupBy('gr.id')
                ->orderBy('gr.month', 'asc')
                ->get();
        } elseif ($this->student_id) {
            $student_id = $this->student_id;
            $group_id = 0;
            $graphics = DB::table('graphics as gr')
                ->join('students as s', 's.id', '=', 'gr.student_id')
                ->join('groups as g', 'g.id', '=', 'gr.group_id')
                ->select('gr.id', 'gr.month', 'gr.amount', 'gr.paid_amount', 'gr.remaining_amount'
                    , 'gr.education', 'gr.kitchen', 'gr.bedroom', 's.name as student', 's.phone', 'g.name as group')
                ->where('gr.student_id', '=', $this->student_id)
                ->where('gr.remaining_amount', '>', 0)
                ->groupBy('gr.id')
                ->orderBy('gr.month', 'asc')
                ->get();
        } elseif ($this->group_id && $this->finish && $this->month) {
            $student_id = 0;
            $group_id = $this->group_id;
            $graphics = DB::table('graphics as gr')
                ->join('students as s', 's.id', '=', 'gr.student_id')
                ->join('groups as g', 'g.id', '=', 'gr.group_id')
                ->select('gr.id', 'gr.month', 'gr.amount', 'gr.paid_amount', 'gr.remaining_amount'
                    , 'gr.education', 'gr.kitchen', 'gr.bedroom', 's.name as student', 's.phone', 'g.name as group')
                ->where('gr.group_id', '=', $this->group_id)
                ->where('gr.month', '=', $this->month)
                ->where('gr.remaining_amount', '=', 0)
                ->groupBy('gr.id')
                ->orderBy('gr.month', 'asc')
                ->get();
        } elseif ($this->group_id && $this->finish) {
            $student_id = 0;
            $group_id = $this->group_id;
            $graphics = DB::table('graphics as gr')
                ->join('students as s', 's.id', '=', 'gr.student_id')
                ->join('groups as g', 'g.id', '=', 'gr.group_id')
                ->select('gr.id', 'gr.month', 'gr.amount', 'gr.paid_amount', 'gr.remaining_amount'
                    , 'gr.education', 'gr.kitchen', 'gr.bedroom', 's.name as student', 's.phone', 'g.name as group')
                ->where('gr.group_id', '=', $this->group_id)
                ->where('gr.remaining_amount', '=', 0)
                ->groupBy('gr.id')
                ->orderBy('gr.month', 'asc')
                ->get();
        } elseif ($this->group_id && $this->month) {
            $student_id = 0;
            $group_id = $this->group_id;
            $graphics = DB::table('graphics as gr')
                ->join('students as s', 's.id', '=', 'gr.student_id')
                ->join('groups as g', 'g.id', '=', 'gr.group_id')
                ->select('gr.id', 'gr.month', 'gr.amount', 'gr.paid_amount', 'gr.remaining_amount'
                    , 'gr.education', 'gr.kitchen', 'gr.bedroom', 's.name as student', 's.phone', 'g.name as group')
                ->where('gr.group_id', '=', $this->group_id)
                ->where('gr.month', '=', $this->month)
                ->where('gr.remaining_amount', '>', 0)
                ->groupBy('gr.id')
                ->orderBy('gr.month', 'asc')
                ->get();
        } elseif ($this->group_id) {
            $student_id = 0;
            $group_id = $this->group_id;
            $graphics = DB::table('graphics as gr')
                ->join('students as s', 's.id', '=', 'gr.student_id')
                ->join('groups as g', 'g.id', '=', 'gr.group_id')
                ->select('gr.id', 'gr.month', 'gr.amount', 'gr.paid_amount', 'gr.remaining_amount'
                    , 'gr.education', 'gr.kitchen', 'gr.bedroom', 's.name as student', 's.phone', 'g.name as group')
                ->where('gr.group_id', '=', $this->group_id)
                ->where('gr.remaining_amount', '>', 0)
                ->groupBy('gr.id')
                ->orderBy('gr.month', 'asc')
                ->get();
        } elseif ($this->finish && $this->month) {
            $student_id = 0;
            $group_id = $this->group_id;
            $graphics = DB::table('graphics as gr')
                ->join('students as s', 's.id', '=', 'gr.student_id')
                ->join('groups as g', 'g.id', '=', 'gr.group_id')
                ->select('gr.id', 'gr.month', 'gr.amount', 'gr.paid_amount', 'gr.remaining_amount'
                    , 'gr.education', 'gr.kitchen', 'gr.bedroom', 's.name as student', 's.phone', 'g.name as group')
                ->where('gr.month', '=', $this->month)
                ->where('gr.remaining_amount', '=', 0)
                ->groupBy('gr.id')
                ->orderBy('gr.month', 'asc')
                ->get();
        } elseif ($this->finish) {
            $student_id = 0;
            $group_id = $this->group_id;
            $graphics = DB::table('graphics as gr')
                ->join('students as s', 's.id', '=', 'gr.student_id')
                ->join('groups as g', 'g.id', '=', 'gr.group_id')
                ->select('gr.id', 'gr.month', 'gr.amount', 'gr.paid_amount', 'gr.remaining_amount'
                    , 'gr.education', 'gr.kitchen', 'gr.bedroom', 's.name as student', 's.phone', 'g.name as group')
                ->where('gr.remaining_amount', '=', 0)
                ->groupBy('gr.id')
                ->orderBy('gr.month', 'asc')
                ->get();
        } elseif ($this->month) {
            $student_id = 0;
            $group_id = 0;
            $graphics = DB::table('graphics as gr')
                ->join('students as s', 's.id', '=', 'gr.student_id')
                ->join('groups as g', 'g.id', '=', 'gr.group_id')
                ->select('gr.id', 'gr.month', 'gr.amount', 'gr.paid_amount', 'gr.remaining_amount'
                    , 'gr.education', 'gr.kitchen', 'gr.bedroom', 's.name as student', 's.phone', 'g.name as group')
                ->where('gr.month', '=', $this->month)
                ->where('gr.remaining_amount', '>', 0)
                ->groupBy('gr.id')
                ->orderBy('gr.month', 'asc')
                ->get();
        } else {
            $student_id = 0;
            $group_id = 0;
            $graphics = DB::table('graphics as gr')
                ->join('students as s', 's.id', '=', 'gr.student_id')
                ->join('groups as g', 'g.id', '=', 'gr.group_id')
                ->select('gr.id', 'gr.month', 'gr.amount', 'gr.paid_amount', 'gr.remaining_amount'
                    , 'gr.education', 'gr.kitchen', 'gr.bedroom', 's.name as student', 's.phone', 'g.name as group')
                ->where('gr.remaining_amount', '>', 0)
                ->groupBy('gr.id')
                ->orderBy('gr.month', 'asc')
                ->get();
        }

        return $graphics;
    }
}
