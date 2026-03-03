<?php

namespace App\Exports;

use App\Models\Result;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class ResultsExport implements FromCollection
{
    public $test_id;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $results = DB::table('results as r')
            ->join('tests as t','t.id','=','r.test_id')
            ->join('students as s','s.id','=','r.student_id')
            ->select('r.id', 's.name as student','t.name as test', 'r.result','t.date')
            ->where('t.id','=',$this->test_id)
            ->orderBy('r.result','desc')
            ->get();
        return $results;
    }

}
