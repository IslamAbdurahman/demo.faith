<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Lid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LidController extends Controller
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
        if ($request->search){
            $search = $request->search;
            $lids = DB::table('lids as l')
                ->leftJoin('lid_students as ls','l.id','=','ls.lid_id')
                ->select('l.*',DB::raw('count(ls.id) as count'))
                ->where('l.name','like', '%'.$request->search.'%')
                ->groupBy('l.id')
                ->paginate($per_page);

        }else {
            $search = '';
            $lids = DB::table('lids as l')
                ->leftJoin('lid_students as ls','l.id','=','ls.lid_id')
                ->select('l.*',DB::raw('count(ls.id) as count'))
                ->groupBy('l.id')
                ->paginate($per_page);
        }

        return view('admin.lids.index',compact('lids','search','per_page'));
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
            'name'=>'required'
        ]);

        $lid = new Lid();
        $lid->name = $request->name;
        $lid->save();

        return redirect()->back()->withErrors([
            'success'=>__('lang.saved'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lid  $lid
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Lid $lid)
    {
        if ($request->per_page){
            $per_page = $request->per_page;
        }else{
            $per_page = 10;
        }
        if ($request->search){
            $search = $request->search;
            $students = DB::table('lid_students as ls')
                ->leftJoin('students as s','s.id','=','ls.student_id')
                ->leftJoin('student_groups as g','s.id','=','g.student_id')
                ->select('s.*',DB::raw('count(g.id) as count'),'ls.id as ls_id','ls.comment')
                ->where('s.name','like', '%'.$request->search.'%')
                ->where('ls.lid_id','=',$lid->id)
                ->groupBy('s.id')
                ->paginate($per_page);
        }else {
            $search = '';
            $students = DB::table('lid_students as ls')
                ->leftJoin('students as s','s.id','=','ls.student_id')
                ->leftJoin('student_groups as g','s.id','=','g.student_id')
                ->select('s.*',DB::raw('count(g.id) as count'),'ls.id as ls_id','ls.comment')
                ->where('ls.lid_id','=',$lid->id)
                ->groupBy('s.id')
                ->paginate($per_page);
        }

        return view('admin.lids.show',compact(
            'students','search','per_page','lid'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lid  $lid
     * @return \Illuminate\Http\Response
     */
    public function edit(Lid $lid)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lid  $lid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lid $lid)
    {
        $request->validate([
            'name'=>'required'
        ]);

        $lid->name = $request->name;
        $lid->update();

        return redirect()->back()->withErrors([
            'success'=>__('lang.updated'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lid  $lid
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lid $lid)
    {
        try {

            $lid->delete();

            return redirect()->back()->withErrors([
                'success'=>__('lang.deleted'),
            ]);
        }catch (\Exception $exception){

            return redirect()->back()->withErrors([
                'error'=>__('lang.cannot_delete'),
            ]);
        }
    }
}
