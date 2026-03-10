<?php

namespace App\Http\Controllers;

use App\Models\Graphic;
use App\Models\Group;
use App\Models\Sms;
use App\Models\SmsService;
use App\Models\StudentGroup;
use App\Http\Requests\StudentGroupStoreRequest;
use App\Http\Requests\StudentGroupUpdateRequest;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentGroupController extends Controller
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
    public function store(StudentGroupStoreRequest $request)
    {
        $students = $request->student_id;

        $months = DB::select("SELECT * FROM graphics WHERE group_id = ".$request->group_id.
            " and month >= '".date('Y-m')."' GROUP BY month");

        foreach ($students as $id){

            $student = Students::find($id);
            $group = Group::find($request->group_id);

            foreach ($months as $month){
                $graphic_check = Graphic::where([
                    'student_id'=>$student->id,
                    'group_id'=>$request->group_id,
                    'month'=>$month->month,
                ])->first();

                $graphic = Graphic::firstOrNew([
                    'student_id'=>$student->id,
                    'group_id'=>$request->group_id,
                    'month'=>$month->month,
                ]);
//                $graphic->month = $month->month;
//                $graphic->student_id = $student->id;
//                $graphic->group_id = $request->group_id;
                if (!$graphic_check){
                    if ($student->discount_education > 0){
                        $graphic->amount = $group->amount-($group->amount/100*$student->discount_education);
                        $graphic->remaining_amount = $group->amount-($group->amount/100*$student->discount_education);
                    }else{
                        $graphic->amount = $group->amount;
                        $graphic->remaining_amount = $group->amount;
                    }
                }
                $graphic->education = $month->education;
                $graphic->kitchen = $month->kitchen;
                $graphic->bedroom = $month->bedroom;
                $graphic->save();
            }


            $day =  \Illuminate\Support\Carbon::now()->setTimezone('Asia/Tashkent')->format('Y-m-d H:i:s');

            $student_group = StudentGroup::firstOrNew([
                'student_id'=>$id,
                'group_id'=>$request->group_id,
            ]);
//            $student_group->student_id= $id;
//            $student_group->group_id= $request->group_id;
            $student_group->date= $day;
            $student_group->save();
        }



        return redirect()->back()->withErrors([
            'success'=>__('lang.saved'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentGroup  $studentGroup
     * @return \Illuminate\Http\Response
     */
    public function show(StudentGroup $studentGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentGroup  $studentGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentGroup $studentGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentGroup  $student
     * @return \Illuminate\Http\Response
     */
    public function update(StudentGroupUpdateRequest $request,$id)
    {
        $student = Students::find($id);

        $sms = SmsService::send_sms($student->phone,'Teacher: '.Auth::user()->name.' -- '.$request->sms);
        SmsService::send_sms($student->parent_phone,'Teacher: '.Auth::user()->name.' -- '.$request->sms);

        Sms::create([
            'student_id'=>$student->id,
            'user_id'=> Auth::user()->id,
            'text'=> 'Teacher: '.Auth::user()->name.' -- '.$request->sms,
            'date'=>tash_time(),
            'service_id'=>$sms->service_id,
            'status'=>$sms->status
        ]);

        return redirect()->back()->withErrors([
            'success'=>__('lang.sms_sent'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentGroup  $studentGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentGroup $studentGroup)
    {
        try {
            $studentGroup->delete();

            return redirect()->back()->withErrors([
                'success'=>__('lang.deleted'),
            ]);
        }catch (\Exception $exception){
            return redirect()->back()->withErrors([
                'success'=>__('lang.cannot_delete'),
            ]);
        }
    }
}
