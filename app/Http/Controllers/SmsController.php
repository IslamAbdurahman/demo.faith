<?php

namespace App\Http\Controllers;

use App\Models\Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\String\s;

class SmsController extends Controller
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
        if ($request->search && $request->from && $request->to){
            $search = $request->search;
            $from = $request->from;
            $to = $request->to;
            $sms = Sms::with([
                'student',
                'service',
                'user'
            ])->whereHas('student',function ($query) use ($request){
                $query->where('name','like', '%'.$request->search.'%');
            })
                ->whereBetween('date',[$request->from,$request->to.' 23:59:59'])
                ->orderBy('date','desc')
                ->paginate($per_page);
        }elseif ($request->from && $request->to){
            $search = '';
            $from = $request->from;
            $to = $request->to;
            $sms = Sms::with([
                'student',
                'service',
                'user'
            ])->whereBetween('date',[$request->from,$request->to.' 23:59:59'])
                ->orderBy('date','desc')
                ->paginate($per_page);
        }elseif ($request->search){
            $search = $request->search;
            $from = date('Y-m-d');
            $to = date('Y-m-d');
            $sms = Sms::with([
                'student',
                'service',
                'user'
            ])->whereHas('student',function ($query) use ($request){
                $query->where('name','like', '%'.$request->search.'%');
            })
                ->orderBy('date','desc')
                ->paginate($per_page);
        }else {
            $search = '';
            $from = date('Y-m-d');
            $to = date('Y-m-d');
            $sms = Sms::with([
                'student',
                'service',
                'user'
            ])->orderBy('date','desc')
                ->paginate($per_page);
        }

//        dd($sms);
        return view('admin.sms.index',compact('sms',
            'search','per_page','from','to'));
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
     * @param  \App\Models\Sms  $sms
     * @return \Illuminate\Http\Response
     */
    public function show(Sms $sms)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sms  $sms
     * @return \Illuminate\Http\Response
     */
    public function edit(Sms $sms)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sms  $sms
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sms $sms)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sms  $sms
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sms $sms)
    {
        try {

            $sms->delete();

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
