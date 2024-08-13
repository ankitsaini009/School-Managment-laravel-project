<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Teacher;
use App\Models\SchoolClass;
use Carbon\Carbon;
use DateTime;

class TeacherAuthController extends Controller
{
    public function loginpage()
    {
        return view('teacher.index');
    }

    public function loginattempt(Request $request)
    {
        $validated = $request->validate([
            'email_or_number' => 'required',
            'password' => 'required'
        ]);

        $teacher = Teacher::where('email', $validated['email_or_number'])->first();
        if (isset($teacher->status) && $teacher->status == 1) {
            if (is_numeric($request->email_or_number)) {
                if (Auth::guard('teacher')->attempt(['number' => $validated['email_or_number'], 'password' => $validated['password']])) {
                    $request->session()->regenerate();
                    Session::flash('success', 'Loging Successfully');
                    return redirect()->route('teacher.dashboard')->with(['success' => true, 'message' => 'Login Successful']);
                } else {
                    Session::flash('error', 'Invailid Credential');
                    return redirect()->route('teacher.login.page');
                }
            } else {
                if (Auth::guard('teacher')->attempt(['email' => $validated['email_or_number'], 'password' => $validated['password']])) {
                    $request->session()->regenerate();
                    Session::flash('success', 'Loging Successfully');
                    return redirect()->route('teacher.dashboard')->with(['success' => true, 'message' => 'Login Successful']);
                } else {
                    Session::flash('error', 'Invailid Credential');
                    return redirect()->route('teacher.login.page');
                }
            }
        } else {
            Session::flash('error', 'Permission denied');
            return redirect()->route('teacher.login.page');
        }
    }

    public function dashboard(Request $request)
    {
        $user = Auth::guard('teacher')->user();
        $getstudent = Student::where('teacher_id', $user->id)->get();
        $classes = SchoolClass::whereIn('id', $getstudent->pluck('class'))->get();
        $firstclass = SchoolClass::whereIn('id', $getstudent->pluck('class'))->first();
        $statusarray = array();
        $studentlist = Student::query();
        if (!empty($request->classes)) {
            $studentlist = $studentlist->where('class', $request->classes);
        }else{
            $studentlist = $studentlist->where('class',$firstclass->id);
        }
        $studentlist = $studentlist->where('teacher_id', $user->id)->get();
        $checkcount = Attendance::query();
        if (!empty($request->month) && !empty($request->year)) {
            $startDate = date('Y-m-01', strtotime($request->year . '-' . $request->month));
            $endDate = date('Y-m-t', strtotime($request->year . '-' . $request->month));


            $checkcount = $checkcount->whereDate('attendance_date', '>=', $startDate)
                ->whereDate('attendance_date', '<=', $endDate);


            $startdate = date('Y-m-01', strtotime($request->year . '-' . $request->month));
            $enddate = date('Y-m-t', strtotime($request->year . '-' . $request->month));
            $enddate = date('Y-m-d', strtotime("+1 months", strtotime($enddate)));
            $calendardate = new DateTime($request->year . '-' . $request->month . '-01');
        } else {
            $calendardate = new DateTime();
            $currentWeekday = (int)$calendardate->format('w');
            if ($currentWeekday == 0) {
                $start = $calendardate;
                $end = (clone $start)->modify('+20 days');
            } else {
                $end = $calendardate->modify('last Sunday'); 
                $start = (clone $end)->modify('-27 days');
            }
            $startDate = date('Y-m-d',$start->getTimestamp());
            $endDate = date('Y-m-d',$end->getTimestamp());
            $checkcount = $checkcount->whereDate('attendance_date', '>=', $startDate)
                ->whereDate('attendance_date', '<=', $endDate);
            }
        $studentarray = array(0);
        foreach ($studentlist as $singlestudent) {
            $studentarray[] = $singlestudent->id;
        }
        $checkcount = $checkcount->whereIn('student_id', $studentarray)->orderBy('id', 'desc')->get();
        $statusarray = array();
        foreach ($checkcount as $singlestatus) {
            $class = 'regular';
            if ($singlestatus->status == 1) {
                $class = 'special';
            }
            $statusarray[$singlestatus->attendance_date . '_' . $singlestatus->student_id] = $class;
        }
        $choosed = $firstclass->id;
        if(!empty($request->classes)){
            $choosed = '';
        }
        return view('teacher.dashboard', compact('statusarray', 'studentlist', 'classes', 'calendardate','choosed'));
    }
}
