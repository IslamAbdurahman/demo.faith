<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Kassa;
use App\Models\Room;
use App\Models\Students;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 1 || Auth::user()->role ==2){

            $students =Students::count();
            $groups = Group::count();
            $teachers = User::where('role','=',4)->count();
            $kassas = Kassa::all();

            $graphics = DB::select("select gr.month, sum(gr.paid_amount) as paid,
                                           sum(gr.remaining_amount) as remaining
                                    from graphics gr group by gr.month;");

            $months = '';
            $paid = '';
            $remaining = '';

            for ($i = 0; $i<count($graphics);$i++){
                $add = date_parse_from_format("Y-m-d", $graphics[$i]->month);
                $months.= $add['month'].',';
                $paid.= $graphics[$i]->paid.',';
                $remaining.= $graphics[$i]->remaining.',';
            }


        }else{
            $student_count =DB::select("select count(sg.student_id) count from `groups` g
                                join student_groups sg on g.id = sg.group_id
                                where g.teacher_id = ".Auth::user()->id."
                                group by g.teacher_id;");
            if (count($student_count) > 0){
                $students = $student_count[0]->count;
            }else{
                $students = 0;
            }
            $groups = Group::where('teacher_id','=',Auth::user()->id)->count();
            $teachers = User::where('role','=',4)->count();
            $kassas = Auth::user()->balance;

            $graphics = DB::select("select gr.month, sum(gr.paid_amount) as paid,
                                   sum(gr.remaining_amount) as remaining
                            from graphics gr
                                join `groups` g on g.id = gr.group_id
                                where teacher_id=".Auth::user()->id."
                            group by gr.month;");

            $months = '';
            $paid = '';
            $remaining = '';

            for ($i = 0; $i<count($graphics);$i++){
                $add = date_parse_from_format("Y-m-d", $graphics[$i]->month);
                $months.= $add['month'].',';
                $paid.= $graphics[$i]->paid.',';
                $remaining.= $graphics[$i]->remaining.',';
            }
        }


        $rooms = DB::table('rooms as r')
            ->select('r.*',DB::raw('count(g.id) as count'))
            ->leftJoin('groups as g', function($q)
            {
                $q->on('r.id', '=', 'g.room_id')
                    ->where('g.status','=', 1);
            })
            ->groupBy('r.id')
            ->get();

        $timetable_groups = DB::table('groups as g')
            ->join('users as t','t.id','=','g.teacher_id')
            ->join('courses as c','c.id','=','g.course_id')
            ->join('rooms as r','r.id','=','g.room_id')
            ->select('g.*','t.name as teacher','c.name as course','r.name as room')
            ->where('g.status','=',1)
            ->orderBy('g.starts_at','asc')
            ->get();

//        dd($timetable_groups);


        $weekdays = array(
            0 => __('lang.sunday'),
            1 => __('lang.monday'),
            2 => __('lang.tuesday'),
            3 => __('lang.wednesday'),
            4 => __('lang.thursday'),
            5 => __('lang.friday'),
            6 => __('lang.saturday'),
        );


        return view('admin.dashboard.index',compact(
            'students','groups','teachers','kassas',
            'months','paid','remaining','rooms','weekdays','timetable_groups'
        ));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
