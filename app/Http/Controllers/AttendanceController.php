<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Group;
use App\Models\Sms;
use App\Models\SmsService;
use App\Http\Requests\AttendanceStoreRequest;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(AttendanceStoreRequest $request)
    {
        $list = [];
        $array = $request->status;
        foreach ($array as $key => $item){
                $list[] = explode(',',$item);
        }

        $array_obj = [];

        foreach ($list as $key => $item){
            $object = new \stdClass();
            $object->status = $item[0];
            $object->student_id = $item[1];
            $object->group_id = $item[2];
            $object->date = $item[3];
            $array_obj[$key] = $object;
        }


        foreach ($array_obj as $item){
            $attend = Attendance::firstOrNew([
                'student_id'=>$item->student_id,
                'group_id'=>$item->group_id,
                'date'=>$item->date
            ])
                ->where('student_id','=',$item->student_id)
                ->where('group_id','=',$item->group_id)
                ->where('date','=',$item->date)
                ->first();
            if ($attend){
                $attend->status = $item->status;
                $attend->student_id = $item->student_id;
                $attend->group_id = $item->group_id;
                $attend->date = date('Y-m-d',strtotime($item->date));
                $attend->save();
            }else{
                $attend = new Attendance();
                $attend->status = $item->status;
                $attend->student_id = $item->student_id;
                $attend->group_id = $item->group_id;
                $attend->date =  date('Y-m-d',strtotime($item->date));
                $attend->save();
            }

            if ($request->sms){
                $student = Students::find($item->student_id);
                $group = Group::find($item->group_id);

                $sms_text = "Dars qoldirildi. Guruh:".$group->name.". ".$group->starts_at."-".$group->ends_at.". Student:".$student->name;

                $sms = SmsService::send_sms($student->phone,'Teacher: '.Auth::user()->name.' -- '.$sms_text);
                SmsService::send_sms($student->parent_phone,'Teacher: '.Auth::user()->name.' -- '.$sms_text);

                Sms::create([
                    'student_id'=>$student->id,
                    'user_id'=> Auth::user()->id,
                    'text'=>'Teacher: '.Auth::user()->name.' -- '.$sms_text,
                    'date'=>tash_time(),
                    'service_id'=>$sms->service_id,
                    'status'=>$sms->status
                ]);
            }

        }


        return redirect()->back()->withErrors([
            'success'=>__('lang.saved'),
        ]);


    }

    /**
     * Display the specified resource.
     *
     * @param  $s_id
     * @param  $g_id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $s_id,$g_id)
    {
        if ($request->per_page){
            $per_page = $request->per_page;
        }else{
            $per_page = 10;
        }

        if ($request->from && $request->to){
            $from = $request->from;
            $to = $request->to;
            $attendances = DB::table('attendances as a')
                ->join('students as s','s.id','=','a.student_id')
                ->select('a.*','s.name')
                ->where('a.student_id','=',$s_id)
                ->where('a.group_id','=',$g_id)
                ->whereBetween('a.date',[$request->from,$request->to])
                ->orderBy('a.date','desc')
                ->paginate($per_page);
        }else{
            $from = date("Y-m-d");
            $to = date("Y-m-d");
            $attendances = DB::table('attendances as a')
                ->join('students as s','s.id','=','a.student_id')
                ->select('a.*','s.name')
                ->where('a.student_id','=',$s_id)
                ->where('a.group_id','=',$g_id)
                ->orderBy('a.date','desc')
                ->paginate($per_page);
        }

        $student = Students::find($s_id);
        $group = Group::find($g_id);

        return view('admin.attendances.show',compact(
            'attendances','per_page','from','to','student','group'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {

        $attendance->delete();

        return redirect()->back()
            ->withErrors([
            'success'=>__('lang.deleted'),
        ]);
    }
}
