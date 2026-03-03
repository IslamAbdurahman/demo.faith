<?php

namespace App\Http\Controllers;

use App\Models\Students;
use Illuminate\Http\Request;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('admin.form.index');
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
                'gender'=>'required',
                'birth_date'=>'required',
                'phone'=>'required|string|min:12|max:12|unique:students,phone',
                'parent_phone'=>'required|string|min:12|max:12',
            ]);

        $students = Students::all()->count();
        $limit = limit_students();

        if ($limit < $students) {
            return redirect()->back()->withErrors([
                'success' => __('lang.limit'),
            ]);
        }

            $student = new Students();
            $student->name = $request->name;
            $student->gender = $request->gender;
            $student->birth_date = $request->birth_date;
            $student->phone = $request->phone;
            $student->parent_phone = $request->parent_phone;
            $student->save();

            return redirect()->back()->withErrors([
                'success'=>__('lang.student_registered'),
            ]);

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
