<?php

namespace App\Http\Controllers;

use App\Exports\ResultsExport;
use App\Models\Result;
use App\Models\Sms;
use App\Models\SmsService;
use App\Models\Students;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ResultController extends Controller
{
    public function export($test_id)
    {
        $results = new ResultsExport();
        $results->test_id = $test_id;
        $test = Test::find($test_id);
        return Excel::download($results, $test->date.'-results.xlsx');
    }

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
    public function store(Request $request)
    {
        $request->validate([
            'test_id'=>'required',
            'student_id'=>'required',
            'result'=>'required'
        ]);

        $result = new Result();
        $result->test_id = $request->test_id;
        $result->student_id = $request->student_id;
        $result->result = $request->result;
        $result->save();

        $student = Students::find($request->student_id);
        $test = Test::find($request->test_id);

        $sms_parent = SmsService::send_sms(
            $student->parent_phone,
            Auth::user()->name." : "."Student: ".$student->name.". Date: ".$test->date.
            ". Test: ".$test->name." Test result: ".$request->result
        );

        $sms = SmsService::send_sms(
            $student->phone,
            Auth::user()->name." : "."Student: ".$student->name.". Date: ".$test->date.
            ". Test: ".$test->name." Test result: ".$request->result
        );

        Sms::create([
            'student_id'=>$student->id,
            'user_id'=> Auth::user()->id,
            'text'=> Auth::user()->name." : "."Student: ".$student->name.". Date: ".$test->date.
                ". Test: ".$test->name." Test result: ".$request->result,
            'date'=>tash_time(),
            'service_id'=>$sms->service_id,
            'status'=>$sms->status
        ]);

        return redirect()->back()->withErrors([
            'success'=> __('lang.saved'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function show(Result $result)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function edit(Result $result)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Result $result)
    {
        $request->validate([
            'result'=>'required'
        ]);

        $result->result = $request->result;
        $result->update();

        $student = Students::find($result->student_id);
        $test = Test::find($result->test_id);

        $sms_parent = SmsService::send_sms(
            $student->parent_phone,
            Auth::user()->name." : "."Updated result : Student: ".$student->name.". Date: ".$test->date.
            ". Test: ".$test->name." Test result: ".$request->result
        );

        $sms = SmsService::send_sms(
            $student->phone,
            Auth::user()->name." : "."Updated result : Student: ".$student->name.". Date: ".$test->date.
            ". Test: ".$test->name." Test result: ".$request->result
        );

        Sms::create([
            'student_id'=>$student->id,
            'user_id'=> Auth::user()->id,
            'text'=> Auth::user()->name." : "."Updated result : Student: ".$student->name.". Date: ".$test->date.
                ". Test: ".$test->name." Test result: ".$request->result,
            'date'=>tash_time(),
            'service_id'=>$sms->service_id,
            'status'=>$sms->status
        ]);

        return redirect()->back()->withErrors([
            'success'=>__('lang.updated'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function destroy(Result $result)
    {
        $result->delete();

        return redirect()->back()->withErrors([
            'success'=>__('lang.deleted'),
        ]);
    }
}
