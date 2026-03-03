<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
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
            $rooms = DB::table('rooms as r')
                ->select('r.*'
                    ,DB::raw("group_concat(grs.name SEPARATOR ', ') as group_names")
                    ,DB::raw("sum(grs.sts) as students")
                )
                ->leftJoinSub("(
                    select g.*, count(sg.id) sts
                    from `groups` g
                             join student_groups sg on g.id = sg.group_id and g.status = 1
                    group by g.id
                )",'grs','grs.room_id','=','r.id')
                ->where('r.name','like', '%'.$request->search.'%')
                ->groupBy('r.id')
                ->paginate($per_page);

        }else {
            $search = '';
            $rooms = DB::table('rooms as r')
                ->select('r.*'
                    ,DB::raw("group_concat(grs.name SEPARATOR ', ') as group_names")
                    ,DB::raw("sum(grs.sts) as students")
                )
                ->leftJoinSub("(
                    select g.*, count(sg.id) sts
                    from `groups` g
                             join student_groups sg on g.id = sg.group_id and g.status = 1
                    group by g.id
                )",'grs','grs.room_id','=','r.id')
                ->groupBy('r.id')
                ->paginate($per_page);

        }

        return view('admin.rooms.index',compact('rooms','search','per_page'));
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

        $room = new Room();
        $room->name = $request->name;
        $room->save();

        return redirect()->back()->withErrors([
            'success'=>__('lang.saved'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Room $room)
    {
        if ($request->per_page){
            $per_page = $request->per_page;
        }else{
            $per_page = 10;
        }
        if ($request->search){
            $search = $request->search;
            $groups = DB::table('groups as g')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('courses as c','c.id','=','g.course_id')
                ->leftJoin('rooms as r','r.id','=','g.room_id')
                ->select('g.*','t.name as teacher','c.name as course','r.name as room')
                ->where('r.id','=',$room->id)
                ->where('g.status','=',1)
                ->where('g.name','like', '%'.$request->search.'%')
                ->orderBy('g.starts_at','asc')
                ->paginate($per_page);
        }else {
            $search = '';
            $groups = DB::table('groups as g')
                ->join('users as t','t.id','=','g.teacher_id')
                ->join('courses as c','c.id','=','g.course_id')
                ->join('rooms as r','r.id','=','g.room_id')
                ->select('g.*','t.name as teacher','c.name as course','r.name as room')
                ->where('r.id','=',$room->id)
                ->where('g.status','=',1)
                ->orderBy('g.starts_at','asc')
                ->paginate($per_page);
        }

        $weekdays = array(
            1 => __('lang.monday'),
            2 => __('lang.tuesday'),
            3 => __('lang.wednesday'),
            4 => __('lang.thursday'),
            5 => __('lang.friday'),
            6 => __('lang.saturday'),
            7 => __('lang.sunday')
        );


        return view('admin.rooms.show',compact('groups',
            'search','per_page','room','weekdays'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        $request->validate([
            'name'=>'required'
        ]);

        $room->name = $request->name;
        $room->update();

        return redirect()->back()->withErrors([
            'success'=>__('lang.updated'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        try {

            $room->delete();

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
