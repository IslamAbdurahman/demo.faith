<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScienceStoreRequest;
use App\Http\Requests\ScienceUpdateRequest;
use App\Models\Science;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use function Symfony\Component\String\s;

class ScienceController extends Controller
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
            $sciences = DB::table('sciences as s')
                ->leftJoinSub("
                select t.id,t.name,t.science_id, count(sg.id) grs
                from `users` t
                    join `groups` g on t.id = g.teacher_id and g.status = 1
                    join student_groups sg on g.id = sg.group_id
                group by t.id",'tgs','tgs.science_id','=','s.id')
                ->select('s.*',DB::raw('count(tgs.id) as teachers'),
                    DB::raw('sum(tgs.grs) as students'))
                ->where('s.name','like', '%'.$request->search.'%')
                ->groupBy('s.id')
                ->paginate($per_page);
        }else {
            $search = '';
            $sciences = DB::table('sciences as s')
                ->leftJoinSub("
                select t.id,t.name,t.science_id, count(sg.id) grs
                from `users` t
                    join `groups` g on t.id = g.teacher_id and g.status = 1
                    join student_groups sg on g.id = sg.group_id
                group by t.id",'tgs','tgs.science_id','=','s.id')
                ->select('s.*',DB::raw('count(tgs.id) as teachers'),
                DB::raw('sum(tgs.grs) as students'))
                ->groupBy('s.id')
                ->paginate($per_page);
        }


        return view('admin.sciences.index',compact('sciences','search','per_page'));
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
    public function store(ScienceStoreRequest $request)
    {
        $science = new Science();
        $science->name = $request->name;
        $science->save();

        return redirect()->back()->withErrors([
            'success'=>__('lang.saved'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Science  $science
     * @return \Illuminate\Http\Response
     */
    public function show(Science $science)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Science  $science
     * @return \Illuminate\Http\Response
     */
    public function edit(Science $science)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Science  $science
     * @return \Illuminate\Http\Response
     */
    public function update(ScienceUpdateRequest $request, Science $science)
    {
        $science->name = $request->name;
        $science->update();

        return redirect()->back()->withErrors([
            'success'=>__('lang.updated'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Science  $science
     * @return \Illuminate\Http\Response
     */
    public function destroy(Science $science)
    {
        try {

            $science->delete();

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
