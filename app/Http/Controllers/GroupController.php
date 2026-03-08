<?php

namespace App\Http\Controllers;

use App\Exports\GroupExport;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\Graphic;
use App\Models\Group;
use App\Models\Room;
use App\Models\Sms;
use App\Models\SmsService;
use App\Models\Students;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class GroupController extends Controller
{
    public function export(Request $request, $group_id)
    {
        $results = new GroupExport();
        $results->group_id = $group_id;
        $results->group_route = $request->group_route;
        $group = Group::find($group_id);
        return Excel::download($results, $group->name.'-results.xlsx');
    }
    public function group_sms(Request $request){
        $request->validate([
            'sms'=>'required',
            'group_id'=>'required'
        ]);

        $students = DB::table('student_groups as sg')
            ->join('students as s','s.id','=','sg.student_id')
            ->join('groups as g','g.id','=','sg.group_id')
            ->select('s.*')
            ->where('sg.group_id','=',$request->group_id)
            ->groupBy('sg.id')
            ->get();


        \App\Jobs\SendSmsJob::dispatch($students, 'Teacher: ' . Auth::user()->name . ' -- ' . $request->sms, Auth::user()->id);

        return redirect()->back()->withErrors([
            'success'=>__('lang.all_sms_sent'),
        ]);

    }
    public function status_group(Request $request, $id){
        $group = Group::find($id);
        if ($group->status == 1){
            $group->status = 0;
        }else{
            $room_groups = DB::table('groups as g')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('courses as c','c.id','=','g.course_id')
                ->join('rooms as r','r.id','=','g.room_id')
                ->select('g.*','t.name as teacher','c.name as course','r.name as room')
                ->where('g.status','=',1)
                ->where('r.id','=',$group->room_id)
                ->where('g.id','!=',$group->id)
                ->orderBy('g.starts_at','asc')
                ->get();

            $check = 1;
            $new_days = explode(',',$group->days);
            foreach ($room_groups as $gr){
                foreach (explode(',',$gr->days) as $day){
                    for($i = 0; $i < count($new_days); $i++){
                        if ($new_days[$i] == $day){
                            if (($group->starts_at >= $gr->starts_at && $group->starts_at <= $gr->ends_at) ||
                                $group->ends_at >= $gr->starts_at && $group->ends_at <= $gr->ends_at){
                                $check = 0;
                            }
                        }
                    }
                }
            }

            if ($check == 1) {
                $group->status = 1;
            }else{
                return redirect()->back()->withErrors([
                    'error'=>__('lang.busy_room'),
                ]);
            }
        }

        $group->update();
        return redirect()->back();
    }
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

        if ($request->group_page && $request->group_route){
            $group_page = $request->group_page;
            $group_route = $request->group_route;
        }else{
            $group_page = 'id';
            $group_route = 'asc';
        }

        if (Auth::user()->role == 1 || Auth::user()->role == 2){
            if ($request->search){
                $search = $request->search;
                $groups = DB::table('groups as g')
                    ->leftJoin('student_groups as sg','g.id','=','sg.group_id')
                    ->leftJoin('users as t','t.id','=','g.teacher_id')
                    ->leftJoin('courses as c','c.id','=','g.course_id')
                    ->leftJoin('rooms as r','r.id','=','g.room_id')
                    ->select('g.*','t.name as teacher','c.name as course','r.name as room',
                    DB::raw("count(sg.id) as students"))
                    ->orderByRaw($group_page.' '.$group_route)
                    ->groupBy('g.id')
                    ->where('g.name','like', '%'.$request->search.'%')
                    ->paginate($per_page);
            }else {
                $search = '';
                $groups = DB::table('groups as g')
                    ->leftJoin('student_groups as sg','g.id','=','sg.group_id')
                    ->leftJoin('users as t','t.id','=','g.teacher_id')
                    ->leftJoin('courses as c','c.id','=','g.course_id')
                    ->leftJoin('rooms as r','r.id','=','g.room_id')
                    ->select('g.*','t.name as teacher','c.name as course','r.name as room',
                    DB::raw("count(sg.id) as students"))
                    ->orderByRaw($group_page.' '.$group_route)
                    ->groupBy('g.id')
                    ->paginate($per_page);
            }

        }else{
            if ($request->search){
                $search = $request->search;
                $groups = DB::table('groups as g')
                    ->leftJoin('student_groups as sg','g.id','=','sg.group_id')
                    ->join('users as t','t.id','=','g.teacher_id')
                    ->join('courses as c','c.id','=','g.course_id')
                    ->leftJoin('rooms as r','r.id','=','g.room_id')
                    ->select('g.*','t.name as teacher','c.name as course','r.name as room',
                    DB::raw("count(sg.id) as students"))
                    ->groupBy('g.id')
                    ->orderByRaw($group_page.' '.$group_route)
                    ->where('g.status','=',1)
                    ->where('g.teacher_id','=',Auth::user()->id)
                    ->where('g.name','like', '%'.$request->search.'%')
                    ->paginate($per_page);
            }else {
                $search = '';
                $groups = DB::table('groups as g')
                    ->leftJoin('student_groups as sg','g.id','=','sg.group_id')
                    ->join('users as t','t.id','=','g.teacher_id')
                    ->join('courses as c','c.id','=','g.course_id')
                    ->join('rooms as r','r.id','=','g.room_id')
                    ->select('g.*','t.name as teacher','c.name as course','r.name as room',
                    DB::raw("count(sg.id) as students"))
                    ->groupBy('g.id')
                    ->orderByRaw($group_page.' '.$group_route)
                    ->where('g.status','=',1)
                    ->where('g.teacher_id','=',Auth::user()->id)
                    ->paginate($per_page);
            }

        }



        $teachers = User::where('role','=',4)->get();
        $courses = Course::all();

        $weekdays = array(
            1 => __('lang.monday'),
            2 => __('lang.tuesday'),
            3 => __('lang.wednesday'),
            4 => __('lang.thursday'),
            5 => __('lang.friday'),
            6 => __('lang.saturday'),
            7 => __('lang.sunday')
        );

        $months = array(
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        );

        $rooms = Room::all();

        Carbon::setLocale(__('lang.date_zone'));



        return view('admin.groups.index',compact('groups',
            'search','per_page','teachers','courses','weekdays','months','rooms','group_page','group_route'));
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
            'name'=>'required',
            'level'=>'required',
            'amount'=>'required',
            'teacher_id'=>'required',
            'course_id'=>'required',
            'room_id'=>'required',
            'days'=>'required',
            'percent'=>'required',
            'starts_at'=>'required',
            'ends_at'=>'required',
        ]);

        $room_groups = DB::table('groups as g')
            ->join('users as t','t.id','=','g.teacher_id')
            ->join('courses as c','c.id','=','g.course_id')
            ->join('rooms as r','r.id','=','g.room_id')
            ->select('g.*','t.name as teacher','c.name as course','r.name as room')
            ->where('g.status','=',1)
            ->where('r.id','=',$request->room_id)
            ->orderBy('g.starts_at','asc')
            ->get();

        $check = 1;
        $new_days = $request->days;
        foreach ($room_groups as $gr){
            foreach (explode(',',$gr->days) as $day){
                for($i = 0; $i < count($new_days); $i++){
                    if ($new_days[$i] == $day){
                        if (($request->starts_at >= $gr->starts_at && $request->starts_at <= $gr->ends_at) ||
                            ($request->ends_at >= $gr->starts_at && $request->ends_at <= $gr->ends_at)){
                            $check = 0;
                        }
                    }
                }
            }
        }

        if ($check == 1){
            $group = new Group();
            $group->name = $request->name;
            $group->level = $request->level;
            $group->amount = $request->amount;
            $group->teacher_id = $request->teacher_id;
            $group->course_id = $request->course_id;
            $group->room_id = $request->room_id;
            $group->days = implode(',',$request->days);
            $group->percent = $request->percent;
            $group->starts_at = $request->starts_at;
            $group->ends_at = $request->ends_at;
            $group->save();
        }else{
            return redirect()->back()->withErrors([
                'error'=>__('lang.busy_room'),
            ]);
        }


        return redirect()->back()->withErrors([
            'success'=>__('lang.saved'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Group $group)
    {
        if ($request->per_page){
            $per_page = $request->per_page;
        }else{
            $per_page = 10;
        }

        if ($request->group_page && $request->group_route){
            $group_page = $request->group_page;
            $group_route = $request->group_route;
        }else{
            $group_page = 'missed';
            $group_route = 'asc';
        }

        if ($request->search){
            $search = $request->search;
            $students = DB::table('student_groups as sg')
                ->leftJoin('students as s','s.id','=','sg.student_id')
                ->leftJoin('groups as g','g.id','=','sg.group_id')
                ->leftJoin('attendances as a', function($q) use ($group)
                {
                    $q->on('a.student_id', '=', 'sg.student_id')
                        ->on('a.group_id','=',DB::raw($group->id));
                })
                ->select('s.*','sg.id as sg_id','sg.date',
                    DB::raw('count(a.id) as missed')
                )
                ->where('g.name','like', '%'.$request->search.'%')
                ->where('sg.group_id','=',$group->id)
                ->orderByRaw($group_page.' '.$group_route)
                ->groupBy('sg.id')
                ->paginate($per_page);
        }else {
            $search = '';
            $students = DB::table('student_groups as sg')
                ->leftJoin('students as s','s.id','=','sg.student_id')
                ->leftJoin('groups as g','g.id','=','sg.group_id')
                ->leftJoin('attendances as a', function($q) use ($group)
                {
                    $q->on('a.student_id', '=', 'sg.student_id')
                        ->on('a.group_id','=',DB::raw($group->id));
                })
                ->select('s.*','sg.id as sg_id','sg.date',
                    DB::raw('count(a.id) as missed')
                )
                ->where('sg.group_id','=',$group->id)
                ->orderByRaw($group_page.' '.$group_route)
                ->groupBy('sg.id')
                ->paginate($per_page);
        }

        $students_all = DB::table('students as s')
             ->leftJoin('student_groups as sg', function($q) use ($group)
                 {
                     $q->on('s.id', '=', 'sg.student_id')
                         ->on('sg.group_id','=',DB::raw($group->id));
                 })
            ->where('sg.id','=',null)
                ->select('s.*')->get();


        $graphic = Graphic::where('month','=',date('Y-m'))->where('group_id','=',$group->id)->first();

        if ($graphic){

        $date = $graphic->month;
        $days_count = date('t',strtotime($date));
        $week_days = explode(',',$group->days);
        $lessons = [];

        $days = array(
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            7 => 'Sunday'
        );

        for ($i = 1; $i <= $days_count ; $i++){
            for ($j = 0; $j < count($week_days);$j++){
                if (date('l',strtotime($date.'-'.$i)) == $days[$week_days[$j]]){
                    $lessons[]=$i;
                }
            }
        }
        }else{
            $lessons = [];
        }

        $attendances = Attendance::where('group_id','=',$group->id)->get();

        return view('admin.groups.show',compact(
            'group','search','per_page',
            'students','students_all','lessons','attendances','group_page','group_route'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        $request->validate([
            'name'=>'required',
            'level'=>'required',
            'amount'=>'required',
            'teacher_id'=>'required',
            'course_id'=>'required',
            'room_id'=>'required',
            'days'=>'required',
            'percent'=>'required',
            'starts_at'=>'required',
            'ends_at'=>'required',
        ]);

        $room_groups = DB::table('groups as g')
            ->join('users as t','t.id','=','g.teacher_id')
            ->join('courses as c','c.id','=','g.course_id')
            ->join('rooms as r','r.id','=','g.room_id')
            ->select('g.*','t.name as teacher','c.name as course','r.name as room')
            ->where('g.status','=',1)
            ->where('r.id','=',$request->room_id)
            ->where('g.id','!=',$group->id)
            ->orderBy('g.starts_at','asc')
            ->get();

        $check = 1;
        $new_days = $request->days;
        foreach ($room_groups as $gr){
            foreach (explode(',',$gr->days) as $day){
                for($i = 0; $i < count($new_days); $i++){
                    if ($new_days[$i] == $day){
                        if (($request->starts_at >= $gr->starts_at && $request->starts_at <= $gr->ends_at) ||
                            ($request->ends_at >= $gr->starts_at && $request->ends_at <= $gr->ends_at)){
                            $check = 0;
                        }
                    }
                }
            }
        }


        if ($check == 1){
            $group->name = $request->name;
            $group->level = $request->level;
            $group->amount = $request->amount;
            $group->teacher_id = $request->teacher_id;
            $group->course_id = $request->course_id;
            $group->room_id = $request->room_id;
            $group->days = implode(',',$request->days);
            $group->percent = $request->percent;
            $group->starts_at = $request->starts_at;
            $group->ends_at = $request->ends_at;
            $group->update();
        }else{
            return redirect()->back()->withErrors([
                'error'=>__('lang.busy_room'),
            ]);
        }



        return redirect()->back()->withErrors([
            'success'=>__('lang.updated'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {

        try {
            $group->delete();

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
