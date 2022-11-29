<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use DB;
use Illuminate\Support\Facades\Storage;
use App\Exports\AttendanceExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB as FacadesDB;

class AttendanceController extends GenericController
{
    private $attendeCodeRepository;
    public function __construct()
    {
        $this->middleware('permission:absen-list|absen-create|absen-edit|absen-delete')->only(['index', 'show']);
        $this->middleware('permission:absen-create')->only(['create', 'store']);
        $this->middleware('permission:absen-edit')->only(['edit', 'update', 'workhour', 'update2']);
        $this->middleware('permission:absen-delete')->only(['delete']);
        $this->attendeCodeRepository;
    }
    public function index()
    {
        $user_id = app('auth')->user()->id;
        if (
            in_array("Staff", (array) app('auth')->user()->getRoleNames()[0]) ||
            in_array("Relawan", (array) app('auth')->user()->getRoleNames()[0])

        ) {
            $admin = $user_id;
        } else {
            $admin = false;
        }
        $attendances = Attendance::join('users', 'users.id', '=', 'attendances.user_id')
            ->when($admin, function ($query, $admin) {
                return $query->where('user_id', $admin);
            })
            ->orderBy('attendances.entry_date', 'desc')
            ->select('users.name', 'attendances.entry_date', 'attendances.category', 'attendances.note', 'attendances.tanggal', 'attendances.waktu')
            ->get();
        return view('attendances.index', compact('attendances'))->with('i');
    }
    public function create()
    {
        $categories = [
            1 => "Work from Office",
            2 => "Work from Home",
            3 => "Rapat/Dinas",
            4 => "Cuti/Tidak Masuk"
        ];
        return view('attendances.create', compact('categories'));
    }
    public function store(Request $request)
    {
        request()->validate([
            'category' => 'required',
            'note' => 'max:255',
        ]);

        $input = $request->all();
        $user_id = app('auth')->user()->id;
        $now = strtotime("now");
        $attendance_time = date("H:i");
        $attendance_date = date("Y-m-d");
        $time = date('12:00');
        $canAT = true;
        $attendance = Attendance::where('user_id', $user_id)->get();
        foreach ($attendance as $at) {
            if ($attendance_date == date('Y-m-d', strtotime($at->tanggal))) {
                $canAT = false;
                return redirect()->route('attendances.create')
                    ->with('error', 'you assigned your attendance today');
                break;
            }
            // if ($attendance_time >= $time) {
            //     $canAT = false;
            //     return redirect()->route('attendances.create')
            //         ->with('error', 'Melewati batas waktu absensi');
            //     break;
            // }
        }
        if ($canAT) {
            $attendance = Attendance::create([
                'entry_date' => $now,
                'tanggal' => $attendance_date,
                'waktu' => $attendance_time,
                'category' => $input['category'],
                'note' => $input['note'],
                'user_id' => $user_id,
            ]);
            return redirect()->route('attendances.index')
                ->with('success', 'Attendance created successfully.');
        } else {
        }


        // return redirect()->route('attendances.index')
        //     ->with('success', 'Attendance created successfully.');
    }

    public function export(Request $request)
    {
        if ($request->timestamp) {
            $startdate = substr($request->timestamp, 0, 10);
            $enddate   = substr($request->timestamp, 13, 10);
            $start_date = date_format(date_create($startdate), "U");
            $end_date   = date_format(date_create($enddate), "U");
        } else {
            $start_date = $end_date = null;
        }
        $start_date_file = date_format(date_create($startdate), "Ymd");
        $end_date_file = date_format(date_create($enddate), "Ymd");
        return Excel::download(new AttendanceExport($start_date, $end_date), 'absensi-' . $start_date_file . '-' . $end_date_file . '.xlsx');
    }
}
