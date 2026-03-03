<?php

namespace App\Http\Controllers;

use App\Models\LidStudent;
use Illuminate\Http\Request;

class LidStudentController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LidStudent  $lidStudent
     * @return \Illuminate\Http\Response
     */
    public function show(LidStudent $lidStudent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LidStudent  $lidStudent
     * @return \Illuminate\Http\Response
     */
    public function edit(LidStudent $lidStudent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LidStudent  $lidStudent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LidStudent $lidStudent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LidStudent  $lidStudent
     * @return \Illuminate\Http\Response
     */
    public function destroy(LidStudent $lidStudent)
    {
        try {
            $lidStudent->delete();

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
