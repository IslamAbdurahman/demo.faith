<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentImportRequest;
use App\Http\Requests\StudentSmsRequest;
use App\Http\Requests\StudentStoreRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Exports\StudentExport;
use App\Imports\StudentsImport;
use App\Jobs\ImportStudentsJob;
use App\Models\Graphic;
use App\Models\Group;
use App\Models\Lid;
use App\Models\LidStudent;
use App\Models\Sms;
use App\Models\SmsService;
use App\Models\StudentGroup;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class StudentsController extends Controller
{
    public function import(StudentImportRequest $request)
    {

//        dd($request->file('file_excel'));

//        $array = Excel::import(new StudentsImport(), $request->file('file_excel'));

        $array = Excel::toArray(new StudentsImport(), $request->file('file_excel'));

//        dd($array[0]);

        ImportStudentsJob::dispatch($array[0]);

        return redirect()->back()->withErrors([
            'success' => __('lang.saved'),
        ]);
    }

    public function export(Request $request)
    {
        $results = new StudentExport();
        $results->search = $request->search;
        $results->group = $request->group;
        $results->group_route = $request->group_route;
        return Excel::download($results, 'Students-' . date('Y-m-d') . '-results.xlsx');
    }


    public function students_sms(StudentSmsRequest $request)
    {

        if ($request->search && $request->group) {
            $search = $request->search;
            $group = $request->group;
            $students = DB::table('students as s')
                ->leftJoin('student_groups as g', 's.id', '=', 'g.student_id')
                ->select('s.*', DB::raw('count(g.id) as count'))
                ->where('s.name', 'like', '%' . $request->search . '%')
                ->orderByRaw($request->group . ' desc')
                ->groupBy('s.id')
                ->get();
        } elseif ($request->search) {
            $search = $request->search;
            $group = '';
            $students = DB::table('students as s')
                ->leftJoin('student_groups as g', 's.id', '=', 'g.student_id')
                ->select('s.*', DB::raw('count(g.id) as count'))
                ->where('s.name', 'like', '%' . $request->search . '%')
                ->groupBy('s.id')
                ->get();
        } elseif ($request->group) {
            $search = '';
            $group = $request->group;
            $students = DB::table('students as s')
                ->leftJoin('student_groups as g', 's.id', '=', 'g.student_id')
                ->select('s.*', DB::raw('count(g.id) as count'))
                ->groupBy('s.id')
                ->orderByRaw($request->group . ' desc')
                ->get();
        } else {
            $search = '';
            $group = '';
            $students = DB::table('students as s')
                ->leftJoin('student_groups as g', 's.id', '=', 'g.student_id')
                ->select('s.*', DB::raw('count(g.id) as count'))
                ->groupBy('s.id')
                ->get();
        }

        \App\Jobs\SendSmsJob::dispatch($students, $request->sms, Auth::user()->id);

        return redirect()->back()->withErrors([
            'success' => __('lang.all_sms_sent'),
        ]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->per_page) {
            $per_page = $request->per_page;
        } else {
            $per_page = 10;
        }

        if ($request->group_route) {
            $group_route = $request->group_route;
        } else {
            $group_route = 'asc';
        }

        if ($request->search && $request->group) {
            $search = $request->search;
            $group = $request->group;
            $students = DB::table('students as s')
                ->leftJoin('student_groups as sg', 's.id', '=', 'sg.student_id')
                ->leftJoin('groups as g', 'g.id', '=', 'sg.group_id')
                ->select('s.*', DB::raw("group_concat(g.name SEPARATOR ', ') as group_names"))
                ->where('s.name', 'like', '%' . $request->search . '%')
                ->orderByRaw($request->group . ' ' . $group_route)
                ->groupBy('s.id')
                ->paginate($per_page);
        } elseif ($request->search) {
            $search = $request->search;
            $group = '';
            $students = DB::table('students as s')
                ->leftJoin('student_groups as sg', 's.id', '=', 'sg.student_id')
                ->leftJoin('groups as g', 'g.id', '=', 'sg.group_id')
                ->select('s.*', DB::raw("group_concat(g.name SEPARATOR ', ') as group_names"))
                ->where('s.name', 'like', '%' . $request->search . '%')
                ->orderByRaw('name ' . $group_route)
                ->groupBy('s.id')
                ->paginate($per_page);
        } elseif ($request->group) {
            $search = '';
            $group = $request->group;
            $students = DB::table('students as s')
                ->leftJoin('student_groups as sg', 's.id', '=', 'sg.student_id')
                ->leftJoin('groups as g', 'g.id', '=', 'sg.group_id')
                ->select('s.*', DB::raw("group_concat(g.name SEPARATOR ', ') as group_names"))
                ->groupBy('s.id')
                ->orderByRaw($request->group . ' ' . $group_route)
                ->paginate($per_page);
        } else {
            $search = '';
            $group = '';
            $students = DB::table('students as s')
                ->leftJoin('student_groups as sg', 's.id', '=', 'sg.student_id')
                ->leftJoin('groups as g', 'g.id', '=', 'sg.group_id')
                ->select('s.*', DB::raw("group_concat(g.name SEPARATOR ', ') as group_names"))
                ->groupBy('s.id')
                ->paginate($per_page);
        }

        $groups = Group::all();
        $lids = Lid::all();

        return view('admin.students.index', compact(
            'students', 'search', 'per_page', 'groups', 'group', 'lids', 'group_route'));
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
    public function store(StudentStoreRequest $request)
    {

        $students = Students::all()->count();
        $limit = limit_students();

        if ($limit < $students) {
            return redirect()->back()->withErrors([
                'error' => __('lang.limit'),
            ]);
        }

        $student = new Students();
        $student->name = $request->name;
        $student->gender = $request->gender;
        $student->birth_date = $request->birth_date ?? null;
        $student->phone = $request->phone ?? null;
        $student->parent_phone = $request->parent_phone ?? null;
        $student->discount_education = $request->discount_education;
        $student->save();

        if ($request->group_id) {

            $months = DB::select("SELECT * FROM graphics WHERE group_id = " . $request->group_id .
                " and month >= '" . date('Y-m') . "' GROUP BY month");

            $group = Group::find($request->group_id);

            foreach ($months as $month) {
                $graphic = new Graphic();
                $graphic->month = $month->month;
                if ($student->discount_education > 0) {
                    $graphic->amount = $group->amount - ($group->amount / 100 * $student->discount_education);
                    $graphic->remaining_amount = $group->amount - ($group->amount / 100 * $student->discount_education);
                } else {
                    $graphic->amount = $group->amount;
                    $graphic->remaining_amount = $group->amount;
                }
                $graphic->education = $month->education;
                $graphic->kitchen = $month->kitchen;
                $graphic->bedroom = $month->bedroom;
                $graphic->student_id = $student->id;
                $graphic->group_id = $request->group_id;
                $graphic->save();
            }

            $day = \Illuminate\Support\Carbon::now()->setTimezone('Asia/Tashkent')->format('Y-m-d H:i:s');
            $student_group = new StudentGroup();
            $student_group->student_id = $student->id;
            $student_group->group_id = $request->group_id;
            $student_group->date = $day;
            $student_group->save();
        }

        if ($request->lid_id && $request->comment) {
            $ls = new LidStudent();
            $ls->lid_id = $request->lid_id;
            $ls->student_id = $student->id;
            $ls->comment = $request->comment;
            $ls->save();
        }

        return redirect()->back()->withErrors([
            'success' => __('lang.saved'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Students $student
     * @return \Illuminate\Http\Response
     */
    public function show(Students $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Students $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Students $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Students $student
     * @return \Illuminate\Http\Response
     */
    public function update(StudentUpdateRequest $request, Students $student)
    {

        $student->name = $request->name;
        $student->gender = $request->gender;
        $student->birth_date = $request->birth_date ?? null;
        $student->parent_phone = $request->parent_phone ?? null;
        $student->phone = $request->phone ?? null;
        $student->discount_education = $request->discount_education;
        $student->save();

        return redirect()->back()->withErrors([
            'success' => __('lang.updated'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Students $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Students $student)
    {
        try {

            $student->delete();

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
