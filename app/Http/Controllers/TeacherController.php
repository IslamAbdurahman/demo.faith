<?php

namespace App\Http\Controllers;

use App\Models\Science;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->search) {
            $search = $request->search;
            $teachers = DB::table('users as u')
                ->join('roles as r', 'r.id', '=', 'u.role')
                ->join('sciences as s', 's.id', '=', 'u.science_id')
                ->leftJoinSub("
                select g.*, count(sg.id) sts
                from `groups` g
                         join student_groups sg on g.id = sg.group_id
                group by g.id", 'grs', 'grs.teacher_id', '=', 'u.id')
                ->select('u.*', 'r.name as role_as', 's.name as science'
                    , DB::raw("count(grs.id) as count_groups")
                    , DB::raw("sum(grs.sts) as students")
                )
                ->where('u.name', 'like', '%' . $request->search . '%')
                ->where('r.id', '=', 4)
                ->groupBy('u.id')
                ->get();
        } else {
            $search = '';
            $teachers = DB::table('users as u')
                ->join('roles as r', 'r.id', '=', 'u.role')
                ->leftJoin('sciences as s', 's.id', '=', 'u.science_id')
                ->leftJoinSub("
                select g.*, count(sg.id) sts
                from `groups` g
                         join student_groups sg on g.id = sg.group_id
                group by g.id", 'grs', 'grs.teacher_id', '=', 'u.id')
                ->select('u.*', 'r.name as role_as', 's.name as science'
                    , DB::raw("count(grs.id) as count_groups")
                    , DB::raw("sum(grs.sts) as students")
                )
                ->where('r.id', '=', 4)
                ->groupBy('u.id')
                ->get();

        }

        $roles = DB::table('roles')->select('roles.*')->get();
        $sciences = Science::all();

        return view('admin.teachers.index', compact('teachers', 'roles', 'search', 'sciences'));
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|string|min:12|max:12|unique:users,phone',
            'science_id' => 'required',
        ]);


        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048'
            ]);
            $filename = time() . rand(1000, 9999) . "." . $request->image->extension();
            $request->file('image')->storeAs('public/images', $filename);

        } else {

            $filename = '';

        }

        $new_teacher = new User();
        $new_teacher->name = $request->name;
        $new_teacher->phone = $request->phone;
        $new_teacher->science_id = $request->science_id;
        $new_teacher->email = $request->email ? $request->email : '';
        $new_teacher->password = $request->password ? Hash::make($request->password) : '';
        $new_teacher->role = 4;

        $new_teacher->image = $filename;

        $new_teacher->save();


        return redirect()->back()->withErrors([
            'success' => __('lang.saved'),
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\User $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(User $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\User $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit(User $teacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $teacher)
    {
        try {
            $request->validate([
                'name' => 'required',
                'phone' => 'required|string|min:12|max:12',
                'science_id' => 'required',
            ]);

            if ($request->phone != $teacher->phone) {
                $request->validate([
                    'phone' => 'required|string|min:12|max:12|unique:users,phone',
                ]);
            }

            if ($request->hasFile('image')) {
                $request->validate([
                    'image' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048'
                ]);
                $filename = time() . rand(1000, 9999) . "." . $request->image->extension();
                $request->file('image')->storeAs('public/images', $filename);

                if (File::exists(storage_path("app/public/images/" . $teacher->image))) {
                    File::delete(storage_path("app/public/images/" . $teacher->image));
                }
                $teacher->image = $filename;
                $teacher->update();

            }

            $teacher->name = $request->name;
            $teacher->phone = $request->phone;
            $teacher->science_id = $request->science_id;
            $teacher->email = $request->email ? $request->email : $teacher->email;
            $teacher->password = $request->password ? Hash::make($request->password) : $teacher->password;
            $teacher->update();

            return redirect()->back()->withErrors([
                'success' => __('lang.updated'),
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors([
                'error' => __('lang.cannot_update'),
            ]);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $teacher)
    {
        try {
            $teacher->delete();
            return redirect()->back()->withErrors([
                'success' => __('lang.deleted'),
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors([
                'error' => __('lang.cannot_delete'),
            ]);
        }
    }
}

