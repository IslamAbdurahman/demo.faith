<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestStoreRequest;
use App\Http\Requests\TestUpdateRequest;
use App\Models\Students;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->per_page){
            $per_page = $request->per_page;
        }else{
            $per_page = 10;
        }
        if ($request->from && $request->to){
            $from = $request->from;
            $to = $request->to;
        }else{
            $from = date('Y-01-01');
            $to = date('Y-m-d');
        }
        if ($request->search){
            $search = $request->search;
            $tests = DB::table('tests as t')
                ->leftJoin('results as r','t.id','=','r.test_id')
                ->select('t.*',DB::raw('count(r.id) as students'))
                ->where('t.name','like', '%'.$request->search.'%')
                ->orderBy('t.date','desc')
                ->whereBetween('t.date',[$from,$to])
                ->groupBy('t.id')
                ->paginate($per_page);
        }else {
            $search = '';
            $tests = DB::table('tests as t')
                ->leftJoin('results as r','t.id','=','r.test_id')
                ->select('t.*',DB::raw('count(r.id) as students'))
                ->whereBetween('t.date',[$from,$to])
                ->groupBy('t.id')
                ->paginate($per_page);
        }

        return view('admin.tests.index',compact('tests','search','per_page','from','to'));
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
    public function store(TestStoreRequest $request)
    {
        $test = new Test();
        $test->name = $request->name;
        $test->date = $request->date;
        $test->save();

        return redirect()->back()->withErrors([
            'success'=>__('lang.saved'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Test $test)
    {

        if ($request->per_page){
            $per_page = $request->per_page;
        }else{
            $per_page = 10;
        }
        if ($request->search){
            $search = $request->search;
            $results = DB::table('results as r')
                ->join('tests as t','t.id','=','r.test_id')
                ->join('students as s','s.id','=','r.student_id')
                ->select('r.*', 's.name as student','t.name as test', 's.id as student_id')
                ->where('s.name','like', '%'.$request->search.'%')
                ->where('t.id','=',$test->id)
                ->orderBy('r.result','desc')
                ->paginate($per_page);
        }else {
            $search = '';
            $results = DB::table('results as r')
                ->join('tests as t','t.id','=','r.test_id')
                ->join('students as s','s.id','=','r.student_id')
                ->select('r.*', 's.name as student','t.name as test', 's.id as student_id')
                ->where('t.id','=',$test->id)
                ->orderBy('r.result','desc')
                ->paginate($per_page);
        }

        $students = DB::table('students as s')
            ->leftJoin('results as r', function($q) use ($test)
            {
                $q->on('s.id', '=', 'r.student_id')
                    ->on('r.test_id','=',DB::raw($test->id));
            })
            ->where('r.id','=',null)
            ->select('s.*')->get();

        return view('admin.tests.show',compact('results',
            'search','per_page','test','students'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function edit(Test $test)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function update(TestUpdateRequest $request, Test $test)
    {
        $test->name = $request->name;
        $test->date = $request->date;
        $test->update();

        return redirect()->back()->withErrors([
            'success'=>__('lang.updated'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function destroy(Test $test)
    {

        try {
            $test->delete();

            return redirect()->back()->withErrors([
                'success'=>__('lang.deleted'),
            ]);
        }catch (\Exception $exception){
            return redirect()->back()->withErrors([
                'error'=>__('lang.cannot_deleted'),
            ]);
        }
    }
}
