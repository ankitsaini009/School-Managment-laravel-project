<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\Student;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Attendance;
use App\Models\Admin;

class AdminAuthController extends Controller
{
    public function loginpage()
    {
        return view('admin.index');
    }
    public function loginattempt(Request $request)
    {
        $validated = $request->validate([
            'email_or_number' => 'required',
            'password' => 'required'
        ]);

        if (is_numeric($request->email_or_number)) {
            if (Auth::guard('admin')->attempt(['number' => $request->email_or_number, 'password' => $request->password])) {
                $request->session()->regenerate();
                Session::flash('success', 'Loging Successfully');
                return redirect()->route('admin.dashboard');
            } else {
                Session::flash('error', 'Invailid Credential');
                return redirect()->route('admin.login.page');
            }
        } else {
            if (Auth::guard('admin')->attempt(['email' => $request->email_or_number, 'password' => $request->password])) {
                $request->session()->regenerate();
                Session::flash('success', 'Login SuccessFully');
                return redirect()->route('admin.dashboard');
            } else {
                Session::flash('error', 'Invailid Credential');
                return redirect()->route('admin.login.page');
            }
        }
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login.page');
    }

    public function dashboard()
    {
        $user = Auth::guard('admin')->user();
        $studentlist = Student::where('teacher_id', $user->id)->get();
        $statusarray = array();

        // $fromDate = date('Y-m-d', strtotime($request->startDate));
        // $toDate = date('Y-m-d', strtotime($request->endDate));

        // $bookings = Attendance::where(function ($query) use ($fromDate, $toDate) {
        //     $query->where(function ($q) use ($fromDate, $toDate) {
        //         $q->whereDate('attendance_date', '<=', $fromDate)
        //             ->whereDate('attendance_date', '>=', $fromDate);
        //     })->orWhere(function ($q) use ($fromDate, $toDate) {
        //         $q->whereDate('attendance_date', '<=', $toDate)
        //             ->whereDate('attendance_date', '>=', $toDate);
        //     })->orWhere(function ($q) use ($fromDate, $toDate) {
        //         $q->whereDate('attendance_date', '>=', $fromDate)
        //             ->whereDate('attendance_date', '<=', $toDate);
        //     });
        // })->get();
        $studentarray = array(0);
        foreach ($studentlist as $singlestudent) {
            $studentarray[] = $singlestudent->id;
        }
        $startdate = date('Y-m-01');
        $enddate = date('Y-m-t');
        $enddate = date('Y-m-d', strtotime("+1 months", strtotime($enddate)));

        $checkcount =  Attendance::whereDate('attendance_date', '>=', $startdate)->whereDate('attendance_date', '<=', $enddate)->whereIn('student_id', $studentarray)->orderBy('id', 'asc')->get();
        $statusarray = array();
        foreach ($checkcount as $singlestatus) {
            $class = 'regular';

            if ($singlestatus->status == 1) {
                $class = 'special';
            }
            $statusarray[$singlestatus->attendance_date . '_' . $singlestatus->student_id] = $class;
        }

        $School = School::orderBy('id', 'desc')->get();
        $SchoolClass = SchoolClass::orderBy('id', 'desc')->get();
        return view('admin.dashboard', compact('statusarray', 'studentlist', 'School', 'SchoolClass'));
    }
}
