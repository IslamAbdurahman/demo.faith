<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseStoreRequest;
use App\Http\Requests\CourseUpdateRequest;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
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
            $courses = DB::table('courses as c')
                ->leftJoinSub("
                select g.*, count(sg.id) sts
                from `groups` g
                         join student_groups sg on g.id = sg.group_id
                group by g.id",'grs','grs.course_id','=','c.id')
                ->select('c.*'
                    ,DB::raw('count(grs.id) as count_groups')
                    ,DB::raw('sum(grs.sts) as students')
                )
                ->where('c.name','like', '%'.$request->search.'%')
                ->groupBy('c.id')
                ->paginate($per_page);
        }else {
            $search = '';
            $courses = DB::table('courses as c')
                ->leftJoinSub("
                select g.*, count(sg.id) sts
                from `groups` g
                         join student_groups sg on g.id = sg.group_id
                group by g.id",'grs','grs.course_id','=','c.id')
                ->select('c.*'
                    ,DB::raw('count(grs.id) as count_groups')
                    ,DB::raw('sum(grs.sts) as students')
                )
                ->groupBy('c.id')
                ->paginate($per_page);
        }

        return view('admin.courses.index',compact('courses','search','per_page'));
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
    public function store(CourseStoreRequest $request)
    {
        $course = new Course();
        $course->name = $request->name;
        $course->save();

        return redirect()->back()->withErrors([
            'success'=>__('lang.saved'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(CourseUpdateRequest $request, Course $course)
    {
        $course->name = $request->name;
        $course->update();

        return redirect()->back()->withErrors([
            'success'=>__('lang.updated'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {

        try {
            $course->delete();

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
