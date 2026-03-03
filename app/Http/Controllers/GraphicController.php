<?php

namespace App\Http\Controllers;

use App\Exports\GraphicExport;
use App\Models\Graphic;
use App\Models\Group;
use App\Models\Sms;
use App\Models\SmsService;
use App\Models\StudentGroup;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class GraphicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function export(Request $request)
    {

        $graphic = new GraphicExport();
        $graphic->finish = $request->finish;
        $graphic->month = $request->month;
        $graphic->student_id = $request->student_id;
        $graphic->group_id = $request->group_id;
        return Excel::download($graphic, date("Y-m-d H:i:s") . '-graphics.xlsx');
    }

    public function graphic_sms(Request $request, $graphic_id)
    {
        $request->validate([
            'sms' => 'required',
        ]);

        $graphic = Graphic::find($graphic_id);
        $student = Students::find($graphic->student_id);

        $sms = SmsService::send_sms($student->phone, $request->sms);
        SmsService::send_sms($student->parent_phone, $request->sms);

        Sms::create([
            'student_id' => $student->id,
            'user_id' => Auth::user()->id,
            'text' => $request->sms,
            'date' => tash_time(),
            'service_id' => $sms->service_id,
            'status' => $sms->status
        ]);

        return redirect()->back()->withErrors([
            'success' => __('lang.sms_sent'),
        ]);

    }


    public function graphic_full_sms(Request $request)
    {
        $request->validate([
            'month' => 'required',
            'group_id' => 'required',
        ]);

        $graphics = DB::table('graphics as gr')
            ->join('students as s', 's.id', '=', 'gr.student_id')
            ->join('groups as g', 'g.id', '=', 'gr.group_id')
            ->select('gr.*', 's.name as student', 's.phone', 'g.name as group')
            ->where('gr.group_id', '=', $request->group_id)
            ->where('gr.month', '=', $request->month)
            ->where('gr.remaining_amount', '>', 0)
            ->groupBy('gr.id')
            ->orderBy('gr.month', 'asc')
            ->get();

        foreach ($graphics as $graphic) {

            $sms_text = Auth::user()->name . " : "
                . "O'quvchi " . $graphic->student . " -> "
                . date("Y", strtotime($graphic->month)) . " " . date("F", strtotime($graphic->month))
                . " oyi "
                . " " . $graphic->group . " guruh uchun "
                . number_format($graphic->remaining_amount, 0, ",",)
                . ". SUM to`lanmagan. Iltimos to`lovni amalga oshiring. Tel : "
                . Auth::user()->phone;

            $student = Students::find($graphic->student_id);

            $sms = SmsService::send_sms($student->phone, $sms_text);
            SmsService::send_sms($student->parent_phone, $sms_text);

            Sms::create([
                'student_id' => $student->id,
                'user_id' => Auth::user()->id,
                'text' => $sms_text,
                'date' => tash_time(),
                'service_id' => $sms->service_id,
                'status' => $sms->status
            ]);

        }

        return redirect()->back()->withErrors([
            'success' => __('lang.all_sms_sent'),
        ]);

    }

    public function index(Request $request)
    {
        if ($request->per_page) {
            $per_page = $request->per_page;
        } else {
            $per_page = 10;
        }
        if ($request->finish) {
            $finish = $request->finish;
        } else {
            $finish = 0;
        }
        if ($request->month) {
            $month = $request->month;
        } else {
            $month = '';
        }

        if (Auth::user()->role == 1 || Auth::user()->role == 2) {

            if ($request->student_id && $request->group_id && $request->finish && $request->month) {
                $student_id = $request->student_id;
                $group_id = $request->group_id;
                $graphics = DB::table('graphics as gr')
                    ->join('students as s', 's.id', '=', 'gr.student_id')
                    ->join('groups as g', 'g.id', '=', 'gr.group_id')
                    ->select('gr.*', 's.name as student', 's.phone', 'g.name as group')
                    ->where('gr.student_id', '=', $request->student_id)
                    ->where('gr.group_id', '=', $request->group_id)
                    ->where('gr.remaining_amount', '=', 0)
                    ->where('gr.month', '=', $request->month)
                    ->groupBy('gr.id')
                    ->orderBy('gr.month', 'asc')
                    ->paginate($per_page);
            } elseif ($request->student_id && $request->group_id && $request->finish) {
                $student_id = $request->student_id;
                $group_id = $request->group_id;
                $graphics = DB::table('graphics as gr')
                    ->join('students as s', 's.id', '=', 'gr.student_id')
                    ->join('groups as g', 'g.id', '=', 'gr.group_id')
                    ->select('gr.*', 's.name as student', 's.phone', 'g.name as group')
                    ->where('gr.student_id', '=', $request->student_id)
                    ->where('gr.group_id', '=', $request->group_id)
                    ->where('gr.remaining_amount', '=', 0)
                    ->groupBy('gr.id')
                    ->orderBy('gr.month', 'asc')
                    ->paginate($per_page);
            } elseif ($request->student_id && $request->group_id && $request->month) {
                $student_id = $request->student_id;
                $group_id = $request->group_id;
                $graphics = DB::table('graphics as gr')
                    ->join('students as s', 's.id', '=', 'gr.student_id')
                    ->join('groups as g', 'g.id', '=', 'gr.group_id')
                    ->select('gr.*', 's.name as student', 's.phone', 'g.name as group')
                    ->where('gr.student_id', '=', $request->student_id)
                    ->where('gr.group_id', '=', $request->group_id)
                    ->where('gr.month', '=', $request->month)
                    ->where('gr.remaining_amount', '>', 0)
                    ->groupBy('gr.id')
                    ->orderBy('gr.month', 'asc')
                    ->paginate($per_page);
            } elseif ($request->student_id && $request->group_id) {
                $student_id = $request->student_id;
                $group_id = $request->group_id;
                $graphics = DB::table('graphics as gr')
                    ->join('students as s', 's.id', '=', 'gr.student_id')
                    ->join('groups as g', 'g.id', '=', 'gr.group_id')
                    ->select('gr.*', 's.name as student', 's.phone', 'g.name as group')
                    ->where('gr.student_id', '=', $request->student_id)
                    ->where('gr.group_id', '=', $request->group_id)
                    ->where('gr.remaining_amount', '>', 0)
                    ->groupBy('gr.id')
                    ->orderBy('gr.month', 'asc')
                    ->paginate($per_page);
            } elseif ($request->student_id && $request->finish && $request->month) {
                $student_id = $request->student_id;
                $group_id = 0;
                $graphics = DB::table('graphics as gr')
                    ->join('students as s', 's.id', '=', 'gr.student_id')
                    ->join('groups as g', 'g.id', '=', 'gr.group_id')
                    ->select('gr.*', 's.name as student', 's.phone', 'g.name as group')
                    ->where('gr.student_id', '=', $request->student_id)
                    ->where('gr.month', '=', $request->month)
                    ->where('gr.remaining_amount', '=', 0)
                    ->groupBy('gr.id')
                    ->orderBy('gr.month', 'asc')
                    ->paginate($per_page);
            } elseif ($request->student_id && $request->finish) {
                $student_id = $request->student_id;
                $group_id = 0;
                $graphics = DB::table('graphics as gr')
                    ->join('students as s', 's.id', '=', 'gr.student_id')
                    ->join('groups as g', 'g.id', '=', 'gr.group_id')
                    ->select('gr.*', 's.name as student', 's.phone', 'g.name as group')
                    ->where('gr.student_id', '=', $request->student_id)
                    ->where('gr.remaining_amount', '=', 0)
                    ->groupBy('gr.id')
                    ->orderBy('gr.month', 'asc')
                    ->paginate($per_page);
            } elseif ($request->student_id && $request->month) {
                $student_id = $request->student_id;
                $group_id = 0;
                $graphics = DB::table('graphics as gr')
                    ->join('students as s', 's.id', '=', 'gr.student_id')
                    ->join('groups as g', 'g.id', '=', 'gr.group_id')
                    ->select('gr.*', 's.name as student', 's.phone', 'g.name as group')
                    ->where('gr.student_id', '=', $request->student_id)
                    ->where('gr.month', '=', $request->month)
                    ->where('gr.remaining_amount', '>', 0)
                    ->groupBy('gr.id')
                    ->orderBy('gr.month', 'asc')
                    ->paginate($per_page);
            } elseif ($request->student_id) {
                $student_id = $request->student_id;
                $group_id = 0;
                $graphics = DB::table('graphics as gr')
                    ->join('students as s', 's.id', '=', 'gr.student_id')
                    ->join('groups as g', 'g.id', '=', 'gr.group_id')
                    ->select('gr.*', 's.name as student', 's.phone', 'g.name as group')
                    ->where('gr.student_id', '=', $request->student_id)
                    ->where('gr.remaining_amount', '>', 0)
                    ->groupBy('gr.id')
                    ->orderBy('gr.month', 'asc')
                    ->paginate($per_page);
            } elseif ($request->group_id && $request->finish && $request->month) {
                $student_id = 0;
                $group_id = $request->group_id;
                $graphics = DB::table('graphics as gr')
                    ->join('students as s', 's.id', '=', 'gr.student_id')
                    ->join('groups as g', 'g.id', '=', 'gr.group_id')
                    ->select('gr.*', 's.name as student', 's.phone', 'g.name as group')
                    ->where('gr.group_id', '=', $request->group_id)
                    ->where('gr.month', '=', $request->month)
                    ->where('gr.remaining_amount', '=', 0)
                    ->groupBy('gr.id')
                    ->orderBy('gr.month', 'asc')
                    ->paginate($per_page);
            } elseif ($request->group_id && $request->finish) {
                $student_id = 0;
                $group_id = $request->group_id;
                $graphics = DB::table('graphics as gr')
                    ->join('students as s', 's.id', '=', 'gr.student_id')
                    ->join('groups as g', 'g.id', '=', 'gr.group_id')
                    ->select('gr.*', 's.name as student', 's.phone', 'g.name as group')
                    ->where('gr.group_id', '=', $request->group_id)
                    ->where('gr.remaining_amount', '=', 0)
                    ->groupBy('gr.id')
                    ->orderBy('gr.month', 'asc')
                    ->paginate($per_page);
            } elseif ($request->group_id && $request->month) {
                $student_id = 0;
                $group_id = $request->group_id;
                $graphics = DB::table('graphics as gr')
                    ->join('students as s', 's.id', '=', 'gr.student_id')
                    ->join('groups as g', 'g.id', '=', 'gr.group_id')
                    ->select('gr.*', 's.name as student', 's.phone', 'g.name as group')
                    ->where('gr.group_id', '=', $request->group_id)
                    ->where('gr.month', '=', $request->month)
                    ->where('gr.remaining_amount', '>', 0)
                    ->groupBy('gr.id')
                    ->orderBy('gr.month', 'asc')
                    ->paginate($per_page);
            } elseif ($request->group_id) {
                $student_id = 0;
                $group_id = $request->group_id;
                $graphics = DB::table('graphics as gr')
                    ->join('students as s', 's.id', '=', 'gr.student_id')
                    ->join('groups as g', 'g.id', '=', 'gr.group_id')
                    ->select('gr.*', 's.name as student', 's.phone', 'g.name as group')
                    ->where('gr.group_id', '=', $request->group_id)
                    ->where('gr.remaining_amount', '>', 0)
                    ->groupBy('gr.id')
                    ->orderBy('gr.month', 'asc')
                    ->paginate($per_page);
            } elseif ($request->finish && $request->month) {
                $student_id = 0;
                $group_id = $request->group_id;
                $graphics = DB::table('graphics as gr')
                    ->join('students as s', 's.id', '=', 'gr.student_id')
                    ->join('groups as g', 'g.id', '=', 'gr.group_id')
                    ->select('gr.*', 's.name as student', 's.phone', 'g.name as group')
                    ->where('gr.month', '=', $request->month)
                    ->where('gr.remaining_amount', '=', 0)
                    ->groupBy('gr.id')
                    ->orderBy('gr.month', 'asc')
                    ->paginate($per_page);
            } elseif ($request->finish) {
                $student_id = 0;
                $group_id = $request->group_id;
                $graphics = DB::table('graphics as gr')
                    ->join('students as s', 's.id', '=', 'gr.student_id')
                    ->join('groups as g', 'g.id', '=', 'gr.group_id')
                    ->select('gr.*', 's.name as student', 's.phone', 'g.name as group')
                    ->where('gr.remaining_amount', '=', 0)
                    ->groupBy('gr.id')
                    ->orderBy('gr.month', 'asc')
                    ->paginate($per_page);
            } elseif ($request->month) {
                $student_id = 0;
                $group_id = 0;
                $graphics = DB::table('graphics as gr')
                    ->join('students as s', 's.id', '=', 'gr.student_id')
                    ->join('groups as g', 'g.id', '=', 'gr.group_id')
                    ->select('gr.*', 's.name as student', 's.phone', 'g.name as group')
                    ->where('gr.month', '=', $request->month)
                    ->where('gr.remaining_amount', '>', 0)
                    ->groupBy('gr.id')
                    ->orderBy('gr.month', 'asc')
                    ->paginate($per_page);
            } else {
                $student_id = 0;
                $group_id = 0;
                $graphics = DB::table('graphics as gr')
                    ->join('students as s', 's.id', '=', 'gr.student_id')
                    ->join('groups as g', 'g.id', '=', 'gr.group_id')
                    ->select('gr.*', 's.name as student', 's.phone', 'g.name as group')
                    ->where('gr.remaining_amount', '>', 0)
                    ->groupBy('gr.id')
                    ->orderBy('gr.month', 'asc')
                    ->paginate($per_page);
            }

        } else {
            if ($request->student_id && $request->group_id && $request->finish && $request->month) {
                $student_id = $request->student_id;
                $group_id = $request->group_id;
                $graphics = DB::table('graphics as gr')
                    ->join('students as s', 's.id', '=', 'gr.student_id')
                    ->join('groups as g', 'g.id', '=', 'gr.group_id')
                    ->select('gr.*', 's.name as student', 's.phone', 'g.name as group')
                    ->where('g.teacher_id', '=', Auth::user()->id)
                    ->where('gr.month', '=', $request->month)
                    ->where('gr.student_id', '=', $request->student_id)
                    ->where('gr.group_id', '=', $request->group_id)
                    ->where('gr.remaining_amount', '=', 0)
                    ->groupBy('gr.id')
                    ->orderBy('gr.month', 'asc')
                    ->paginate($per_page);
            } elseif ($request->student_id && $request->group_id && $request->finish) {
                $student_id = $request->student_id;
                $group_id = $request->group_id;
                $graphics = DB::table('graphics as gr')
                    ->join('students as s', 's.id', '=', 'gr.student_id')
                    ->join('groups as g', 'g.id', '=', 'gr.group_id')
                    ->select('gr.*', 's.name as student', 's.phone', 'g.name as group')
                    ->where('g.teacher_id', '=', Auth::user()->id)
                    ->where('gr.student_id', '=', $request->student_id)
                    ->where('gr.group_id', '=', $request->group_id)
                    ->where('gr.remaining_amount', '=', 0)
                    ->groupBy('gr.id')
                    ->orderBy('gr.month', 'asc')
                    ->paginate($per_page);
            } elseif ($request->student_id && $request->group_id && $request->month) {
                $student_id = $request->student_id;
                $group_id = $request->group_id;
                $graphics = DB::table('graphics as gr')
                    ->join('students as s', 's.id', '=', 'gr.student_id')
                    ->join('groups as g', 'g.id', '=', 'gr.group_id')
                    ->select('gr.*', 's.name as student', 's.phone', 'g.name as group')
                    ->where('g.teacher_id', '=', Auth::user()->id)
                    ->where('gr.month', '=', $request->month)
                    ->where('gr.student_id', '=', $request->student_id)
                    ->where('gr.group_id', '=', $request->group_id)
                    ->where('gr.remaining_amount', '>', 0)
                    ->groupBy('gr.id')
                    ->orderBy('gr.month', 'asc')
                    ->paginate($per_page);
            } elseif ($request->student_id && $request->group_id) {
                $student_id = $request->student_id;
                $group_id = $request->group_id;
                $graphics = DB::table('graphics as gr')
                    ->join('students as s', 's.id', '=', 'gr.student_id')
                    ->join('groups as g', 'g.id', '=', 'gr.group_id')
                    ->select('gr.*', 's.name as student', 's.phone', 'g.name as group')
                    ->where('g.teacher_id', '=', Auth::user()->id)
                    ->where('gr.student_id', '=', $request->student_id)
                    ->where('gr.group_id', '=', $request->group_id)
                    ->where('gr.remaining_amount', '>', 0)
                    ->groupBy('gr.id')
                    ->orderBy('gr.month', 'asc')
                    ->paginate($per_page);
            } elseif ($request->student_id && $request->finish && $request->month) {
                $student_id = $request->student_id;
                $group_id = 0;
                $graphics = DB::table('graphics as gr')
                    ->join('students as s', 's.id', '=', 'gr.student_id')
                    ->join('groups as g', 'g.id', '=', 'gr.group_id')
                    ->select('gr.*', 's.name as student', 's.phone', 'g.name as group')
                    ->where('g.teacher_id', '=', Auth::user()->id)
                    ->where('gr.month', '=', $request->month)
                    ->where('gr.student_id', '=', $request->student_id)
                    ->where('gr.remaining_amount', '=', 0)
                    ->groupBy('gr.id')
                    ->orderBy('gr.month', 'asc')
                    ->paginate($per_page);
            } elseif ($request->student_id && $request->finish) {
                $student_id = $request->student_id;
                $group_id = 0;
                $graphics = DB::table('graphics as gr')
                    ->join('students as s', 's.id', '=', 'gr.student_id')
                    ->join('groups as g', 'g.id', '=', 'gr.group_id')
                    ->select('gr.*', 's.name as student', 's.phone', 'g.name as group')
                    ->where('g.teacher_id', '=', Auth::user()->id)
                    ->where('gr.student_id', '=', $request->student_id)
                    ->where('gr.remaining_amount', '=', 0)
                    ->groupBy('gr.id')
                    ->orderBy('gr.month', 'asc')
                    ->paginate($per_page);
            } elseif ($request->student_id && $request->month) {
                $student_id = $request->student_id;
                $group_id = 0;
                $graphics = DB::table('graphics as gr')
                    ->join('students as s', 's.id', '=', 'gr.student_id')
                    ->join('groups as g', 'g.id', '=', 'gr.group_id')
                    ->select('gr.*', 's.name as student', 's.phone', 'g.name as group')
                    ->where('g.teacher_id', '=', Auth::user()->id)
                    ->where('gr.month', '=', $request->month)
                    ->where('gr.student_id', '=', $request->student_id)
                    ->where('gr.remaining_amount', '>', 0)
                    ->groupBy('gr.id')
                    ->orderBy('gr.month', 'asc')
                    ->paginate($per_page);
            } elseif ($request->student_id) {
                $student_id = $request->student_id;
                $group_id = 0;
                $graphics = DB::table('graphics as gr')
                    ->join('students as s', 's.id', '=', 'gr.student_id')
                    ->join('groups as g', 'g.id', '=', 'gr.group_id')
                    ->select('gr.*', 's.name as student', 's.phone', 'g.name as group')
                    ->where('g.teacher_id', '=', Auth::user()->id)
                    ->where('gr.student_id', '=', $request->student_id)
                    ->where('gr.remaining_amount', '>', 0)
                    ->groupBy('gr.id')
                    ->orderBy('gr.month', 'asc')
                    ->paginate($per_page);
            } elseif ($request->group_id && $request->finish && $request->month) {
                $student_id = 0;
                $group_id = $request->group_id;
                $graphics = DB::table('graphics as gr')
                    ->join('students as s', 's.id', '=', 'gr.student_id')
                    ->join('groups as g', 'g.id', '=', 'gr.group_id')
                    ->select('gr.*', 's.name as student', 's.phone', 'g.name as group')
                    ->where('g.teacher_id', '=', Auth::user()->id)
                    ->where('gr.month', '=', $request->month)
                    ->where('gr.group_id', '=', $request->group_id)
                    ->where('gr.remaining_amount', '=', 0)
                    ->groupBy('gr.id')
                    ->orderBy('gr.month', 'asc')
                    ->paginate($per_page);
            } elseif ($request->group_id && $request->finish) {
                $student_id = 0;
                $group_id = $request->group_id;
                $graphics = DB::table('graphics as gr')
                    ->join('students as s', 's.id', '=', 'gr.student_id')
                    ->join('groups as g', 'g.id', '=', 'gr.group_id')
                    ->select('gr.*', 's.name as student', 's.phone', 'g.name as group')
                    ->where('g.teacher_id', '=', Auth::user()->id)
                    ->where('gr.group_id', '=', $request->group_id)
                    ->where('gr.remaining_amount', '=', 0)
                    ->groupBy('gr.id')
                    ->orderBy('gr.month', 'asc')
                    ->paginate($per_page);
            } elseif ($request->group_id && $request->month) {
                $student_id = 0;
                $group_id = $request->group_id;
                $graphics = DB::table('graphics as gr')
                    ->join('students as s', 's.id', '=', 'gr.student_id')
                    ->join('groups as g', 'g.id', '=', 'gr.group_id')
                    ->select('gr.*', 's.name as student', 's.phone', 'g.name as group')
                    ->where('g.teacher_id', '=', Auth::user()->id)
                    ->where('gr.month', '=', $request->month)
                    ->where('gr.group_id', '=', $request->group_id)
                    ->where('gr.remaining_amount', '>', 0)
                    ->groupBy('gr.id')
                    ->orderBy('gr.month', 'asc')
                    ->paginate($per_page);
            } elseif ($request->group_id) {
                $student_id = 0;
                $group_id = $request->group_id;
                $graphics = DB::table('graphics as gr')
                    ->join('students as s', 's.id', '=', 'gr.student_id')
                    ->join('groups as g', 'g.id', '=', 'gr.group_id')
                    ->select('gr.*', 's.name as student', 's.phone', 'g.name as group')
                    ->where('g.teacher_id', '=', Auth::user()->id)
                    ->where('gr.group_id', '=', $request->group_id)
                    ->where('gr.remaining_amount', '>', 0)
                    ->groupBy('gr.id')
                    ->orderBy('gr.month', 'asc')
                    ->paginate($per_page);
            } elseif ($request->finish && $request->month) {
                $student_id = 0;
                $group_id = $request->group_id;
                $graphics = DB::table('graphics as gr')
                    ->join('students as s', 's.id', '=', 'gr.student_id')
                    ->join('groups as g', 'g.id', '=', 'gr.group_id')
                    ->select('gr.*', 's.name as student', 's.phone', 'g.name as group')
                    ->where('g.teacher_id', '=', Auth::user()->id)
                    ->where('gr.month', '=', $request->month)
                    ->where('gr.remaining_amount', '=', 0)
                    ->groupBy('gr.id')
                    ->orderBy('gr.month', 'asc')
                    ->paginate($per_page);
            } elseif ($request->finish) {
                $student_id = 0;
                $group_id = $request->group_id;
                $graphics = DB::table('graphics as gr')
                    ->join('students as s', 's.id', '=', 'gr.student_id')
                    ->join('groups as g', 'g.id', '=', 'gr.group_id')
                    ->select('gr.*', 's.name as student', 's.phone', 'g.name as group')
                    ->where('g.teacher_id', '=', Auth::user()->id)
                    ->where('gr.remaining_amount', '=', 0)
                    ->groupBy('gr.id')
                    ->orderBy('gr.month', 'asc')
                    ->paginate($per_page);
            } elseif ($request->month) {
                $student_id = 0;
                $group_id = $request->group_id;
                $graphics = DB::table('graphics as gr')
                    ->join('students as s', 's.id', '=', 'gr.student_id')
                    ->join('groups as g', 'g.id', '=', 'gr.group_id')
                    ->select('gr.*', 's.name as student', 's.phone', 'g.name as group')
                    ->where('g.teacher_id', '=', Auth::user()->id)
                    ->where('gr.month', '=', $request->month)
                    ->groupBy('gr.id')
                    ->orderBy('gr.month', 'asc')
                    ->paginate($per_page);
            } else {
                $student_id = 0;
                $group_id = 0;
                $graphics = DB::table('graphics as gr')
                    ->join('students as s', 's.id', '=', 'gr.student_id')
                    ->join('groups as g', 'g.id', '=', 'gr.group_id')
                    ->select('gr.*', 's.name as student', 's.phone', 'g.name as group')
                    ->where('g.teacher_id', '=', Auth::user()->id)
                    ->where('gr.remaining_amount', '>', 0)
                    ->groupBy('gr.id')
                    ->orderBy('gr.month', 'asc')
                    ->paginate($per_page);
            }
        }


        $students = Students::all();
        if (Auth::user()->role == 1 || Auth::user()->role == 2) {
            $groups = Group::all();
        } else {
            $groups = Group::where('teacher_id', Auth::user()->id)->get();
        }

        Carbon::setLocale(__('lang.date_zone'));

        return view('admin.graphics.index', compact('graphics', 'month',
            'per_page', 'students', 'groups', 'student_id', 'group_id', 'finish'));
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
            'year' => 'required',
            'month_list' => 'required',
            'group_id' => 'required',
            'education' => 'required'
        ]);

        $students = DB::table('students as s')
            ->join('student_groups as sg', 's.id', '=', 'sg.student_id')
            ->where('sg.group_id', '=', $request->group_id)
            ->select('s.*')->get();

        $group = Group::find($request->group_id);
        $months = $request->month_list;


        foreach ($students as $student) {
            foreach ($months as $month) {
                $graphic_check = Graphic::where('month', '=', $request->year . '-' . $month)
                    ->where('student_id', '=', $student->id)
                    ->where('group_id', '=', $request->group_id)
                    ->first();

                if (!$graphic_check) {
                    $graphic = new Graphic();
                    $graphic->month = $request->year . '-' . $month;
                    if ($student->discount_education > 0) {
                        $graphic->amount = $group->amount - ($group->amount / 100 * $student->discount_education);
                        $graphic->remaining_amount = $group->amount - ($group->amount / 100 * $student->discount_education);
                    } else {
                        $graphic->amount = $group->amount;
                        $graphic->remaining_amount = $group->amount;
                    }
                    $graphic->education = $request->education ? 1 : 0;
                    $graphic->kitchen = $request->kitchen ? 1 : 0;
                    $graphic->bedroom = $request->bedroom ? 1 : 0;
                    $graphic->student_id = $student->id;
                    $graphic->group_id = $request->group_id;
                    $graphic->save();

                } else {
                    $graphic_check->amount = $group->amount;
                    $graphic_check->remaining_amount = $group->amount - $graphic_check->paid_amount;
                    $graphic_check->save();
                }
            }
        }

        return redirect()->back()->withErrors([
            'success' => __('lang.saved'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Graphic $graphic
     * @return \Illuminate\Http\Response
     */
    public function show(Graphic $graphic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Graphic $graphic
     * @return \Illuminate\Http\Response
     */
    public function edit(Graphic $graphic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Graphic $graphic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Graphic $graphic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Graphic $graphic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Graphic $graphic)
    {

        if ($graphic->paid_amount == 0) {
            $graphic->delete();
            return redirect()->back()->withErrors([
                'success' => __('lang.deleted'),
            ]);
        }

        return redirect()->back()->withErrors([
            'error' => __('lang.cannot_delete'),
        ]);
    }
}
