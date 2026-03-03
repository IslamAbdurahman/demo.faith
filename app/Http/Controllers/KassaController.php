<?php

namespace App\Http\Controllers;

use App\Models\Kassa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KassaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $kassas = Kassa::all();
        $workers = DB::table('users as u')
            ->join('roles as r', 'r.id', '=', 'u.role')
            ->select('u.*','r.name as role_as')
            ->get();

        return view('admin.kassas.index',compact('kassas','workers'));
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
     * @param  \App\Models\Kassa  $kassa
     * @return \Illuminate\Http\Response
     */
    public function show(Kassa $kassa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kassa  $kassa
     * @return \Illuminate\Http\Response
     */
    public function edit(Kassa $kassa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kassa  $kassa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kassa $kassa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kassa  $kassa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kassa $kassa)
    {
//
    }
}
