<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\SchoolClass;
use App\Models\School;
use App\Models\Banner;
use App\Models\Subject;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Document;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use DateTime;





class IndexController extends Controller
{
    public function classindex(Request $request)
    {
        if ($request->ajax()) {
            $classes = SchoolClass::orderBy('id', 'DESC')->get();
            return Datatables::of($classes)->addIndexColumn()->addColumn('action', function ($row) {
                $actionBtn = '<a href="javascript:void(0);" class="editclass btn btn-success btn-sm" classid="' . $row->id . '">Edit</a>
                    <a href="' . route('delete.class', ['id' => $row->id]) . '" class="btn btn-danger btn-sm">Delete</a>';
                return $actionBtn;
            })->addColumn('subjects', function ($row) {
                $idsArray = explode(',', $row->subjects);
                $subjects = Subject::whereIn('id', $idsArray)->where('status', '1')->get();
                $subjectname = '';
                foreach ($subjects as $subject) {
                    $subjectname .= $subject->subject_name;
                    $subjectname .= ',';
                }
                return $subjectname;
            })->addColumn('status', function ($row) {
                if ($row->status == 1) {
                    $status = '<span class="badge bg-success">Active</span>';
                } else {
                    $status = '<span class="badge bg-danger">Inactive</span>';
                }
                return $status;
            })->rawColumns(['action', 'status'])->make(true);
        }
        $subjects = Subject::all();
        return view('front.classes.index', compact('subjects'));
    }

    public function classadd(Request $request)
    {
        if (SchoolClass::where('class_name', $request->class_name)->exists()) {
            return redirect()->back()->with(['error' => 'This Class Allredy Added']);
        } else {
            $class = new SchoolClass;
            $user = Auth::guard('teacher')->user();
            $class->created_by = $user->name;
            $class->class_name = $request->class_name;
            $class->status = $request->status;
            $class->save();
            return redirect()->back();
        }
    }
    public function classedit(Request $request)
    {
        $class = SchoolClass::find($request->class_id);
        $user = Auth::guard('teacher')->user();
        $class->created_by = $user->name;
        $class->class_name = $request->class_name;
        $class->status = $request->status;
        $class->save();
        return redirect()->back();
    }


    public function attendances_add(Request $request)
    {
        $weekDates = $this->datearray($request->date);
        $studentData = $request->studentdata;
            foreach ($weekDates as $date) {
                $existingAttendance = Attendance::where('student_id', $request->studentdata)
                ->where('attendance_date', $date)
                ->first();
                if(!$existingAttendance){
                    if (date('D', strtotime($date)) != 'Sat' && date('D', strtotime($date)) != 'Sun') {
                        $attendance = new Attendance;
                        $attendance->student_id = $studentData;
                        $attendance->attendance_date = $date;
                        $attendance->save();
                    }
                }else{
                    Attendance::where('student_id', $studentData)->where('attendance_date', $date)->delete();
                }
            }
            return response()->json(['success' => true, 'message' => 'Action Completed']);
        }

    public function datearray($given_date)
    {
        // Initialize the start date as a DateTime object
        $start_date = new \DateTime($given_date);

        // Find the day of the week (0 for Sunday, 1 for Monday, ..., 6 for Saturday)
        $day_of_week = (int)$start_date->format('w');
        $diff = $day_of_week;
        // Modify the start date to the start of the week (Sunday)
        $start_date->modify("-$diff days");
        $dates = array();
        for ($i = 0; $i < 7; $i++) {
            $date = clone $start_date;
            $date->modify("+$i days");
            $formatted_date = $date->format('Y-m-d');
            $dates[] = $formatted_date;
        }
        return $dates;
    }


    public function calendar()
    {
        return view('front.calendar');
    }

   public function getDatesBetweenDates($start, $end)
    {
        $dates = array();
        $current = strtotime($start);
        $end = strtotime($end);

        while ($current <= $end) {
            $dates[] = date('Y-m-d', $current);
            $current = strtotime('+1 day', $current);
        }

        return $dates;
    }

    public function attendancesreport(Request $request)
    {
        $schoolData = array();
        $Schools = School::query();
        if (!empty($request->school)) {
            $Schools = $Schools->where('id', $request->school);
        }
        $Schools = $Schools->orderBy('id', 'desc')->get();
        foreach ($Schools as $school){
            $singalschool = array();
            $singalschool['students'] = 0;
            $singalschool['avg_attendance'] = 0;
            $singalschool['school_name'] = $school->name;
            $teacherData = Teacher::where('school', $school->id)->pluck('id')->toArray();
            if (!empty($teacherData)) {
                $students = Student::query();
                if (!empty($request->class)) {
                    $students =  $students->where('class', $request->class);
                }
                $students =  $students->whereIn('teacher_id', $teacherData)->get();
                $studentsids = $students->pluck('id')->toArray();
                $classids = $students->pluck('class')->toArray();
                $singalschool['students'] = count($studentsids);
                $classes = SchoolClass::whereIn('id',$classids)->get();
                $calendardate = new DateTime();
                $currentWeekday = (int)$calendardate->format('w');
                if ($currentWeekday == 0) {
                    $start = $calendardate->modify('this Monday'); 
                    $end = (clone $start)->modify('+6 days'); 
                } else {
                    $end = $calendardate->modify('last Sunday'); 
                    $start = (clone $end)->modify('-6 days');
                }
                $startDate = date('Y-m-d',$start->getTimestamp());
                $endDate = date('Y-m-d',$end->getTimestamp());
                
                $dates = $this->getDatesBetweenDates($startDate,$endDate);
                $classesavg = array();
                foreach($classes as $class){
                    $classstudents = Student::where('class',$class->id)->whereIn('id',$studentsids)->pluck('id')->toArray();

                if (!empty($classstudents) && count($classstudents)>0) {
                    $count = 0;
                    foreach($dates as $dateString){
                        $date = Carbon::parse($dateString);
                        $dayName = $date->format('l');
                        if($dayName == 'Sunday' || $dayName == 'Saturday'){
                        }else{
                            $count +=1; 
                        }
                    }
                    $attendance = Attendance::whereDate('attendance_date', '>=', $startDate)->whereDate('attendance_date', '<=', $endDate)->whereIn('student_id', $classstudents)->count();
                    $totalday = $count;
                    $totaldays = $totalday*count($classstudents);
                    $avrg = round(($attendance/$totaldays)*100,2);
                    $classesavg[] = $avrg;
                }
            }

            $singalschool['totaldays'] = $count;
            $avgsum = array_sum($classesavg);
            if($avgsum == 0){
                $singalschool['avg_attendance'] = 0;
            }else{
                $singalschool['avg_attendance'] = round(($avgsum/count($classesavg)),2);
            }
        }
            $schoolData[] = $singalschool;

        }
        // $datesarray = $this->datearray(date('Y-m-d'));
        // $firstdate = $datesarray[0];
        // $enddate = $datesarray[count($datesarray) - 1];
        $Student = Student::orderBy('id', 'desc')->get();
        $SchoolClass = SchoolClass::orderBy('id', 'desc')->get();
        $Teacher = Teacher::orderBy('id', 'desc')->get();
        $schools = School::all();
        // $alldata = "";
        // $dataarray = array();
        // if (!empty($request->school)) {
        //     $Teacherarr = Teacher::where('school', $request->school)->pluck('id')->toArray();
        //     $Student = Student::whereIn('teacher_id', $Teacherarr);
        //     if (isset($request->class) && !empty($request->class)) {
        //         $Student->where('class', $request->class);
        //     }
        //     $Student = $Student->get();

        //     $uniqueclass = $Student->pluck('class')->unique();

        //     foreach ($uniqueclass as $singleclass) {
        //         $singlearr = array();
        //         $totalstudent = Student::whereIn('teacher_id', $Teacherarr)->where('class', $singleclass)->get();
        //         $classstudentids = array(0);
        //         foreach ($totalstudent as $sindlestudent) {
        //             $classstudentids[] = $sindlestudent->id;
        //         }
        //         $getattendance = Attendance::whereIn('student_id', $classstudentids)->whereDate('attendance_date', '>=', $firstdate)->whereDate('attendance_date', '<=', $enddate)->count();
        //         $studentclass = SchoolClass::find($singleclass);
        //         $totaldays = count($datesarray) * $totalstudent->count();
        //         $singlearr['class'] = ucfirst($studentclass->class_name);
        //         $singlearr['totalstudent'] = $totalstudent->count();
        //         $singlearr['totalattendance'] = $totaldays;
        //         $singlearr['totalpresent'] = $getattendance;
        //         $singlearr['percentage'] = ($getattendance / $totaldays) * 100;
        //         $dataarray[] = $singlearr;
        //     }
        // }
        return view('admin.attendancesreport', compact('Student', 'SchoolClass','Teacher','schools','schoolData'));
    }

    public function monthlyreport(Request $request)
    {
        $schoolData = array();
        $Schools = School::query();
        if (!empty($request->school)) {
            $Schools = $Schools->where('id', $request->school);
        }
        $Schools = $Schools->orderBy('id', 'desc')->get();
        foreach ($Schools as $school){
            $singalschool = array();
            $singalschool['students'] = 0;
            $singalschool['avg_attendance'] = 0;
            $singalschool['school_name'] = $school->name;
            $teacherData = Teacher::where('school', $school->id)->pluck('id')->toArray();
            if (!empty($teacherData)) {
                $students = Student::query();
                if (!empty($request->class)) {
                    $students =  $students->where('class', $request->class);
                }
                $students =  $students->whereIn('teacher_id', $teacherData)->get();
                $studentsids = $students->pluck('id')->toArray();
                $classids = $students->pluck('class')->toArray();
                $singalschool['students'] = count($studentsids);
                $classes = SchoolClass::whereIn('id',$classids)->get();
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
                
                $dates = $this->getDatesBetweenDates($startDate,$endDate);
                $classesavg = array();
                foreach($classes as $class){
                    $classstudents = Student::where('class',$class->id)->whereIn('id',$studentsids)->pluck('id')->toArray();

                if (!empty($classstudents) && count($classstudents)>0) {
                    $count = 0;
                    foreach($dates as $dateString){
                        $date = Carbon::parse($dateString);
                        $dayName = $date->format('l');
                        if($dayName == 'Sunday' || $dayName == 'Saturday'){
                        }else{
                            $count +=1; 
                        }
                    }
                    $attendance = Attendance::whereDate('attendance_date', '>=', $startDate)->whereDate('attendance_date', '<=', $endDate)->whereIn('student_id', $classstudents)->count();
                    $totalday = $count;
                    $totaldays = $totalday*count($classstudents);
                    $avrg = round(($attendance/$totaldays)*100,2);
                    $classesavg[] = $avrg;
                }
            }

            $singalschool['totaldays'] = $count;
            $avgsum = array_sum($classesavg);
            if($avgsum == 0){
                $singalschool['avg_attendance'] = 0;
            }else{
                $singalschool['avg_attendance'] = round(($avgsum/count($classesavg)),2);
            }
        }
            $schoolData[] = $singalschool;

        }
        // $datesarray = $this->datearray(date('Y-m-d'));
        // $firstdate = $datesarray[0];
        // $enddate = $datesarray[count($datesarray) - 1];
        $Student = Student::orderBy('id', 'desc')->get();
        $SchoolClass = SchoolClass::orderBy('id', 'desc')->get();
        $Teacher = Teacher::orderBy('id', 'desc')->get();
        $schools = School::all();

        return view('admin.monthlyreport', compact('Student', 'SchoolClass', 'schools', 'Teacher', 'schoolData'));
    }
    public function adduser(Request $request)
    {
        //dd($request->all());
        $validated = $request->validate([
            'Teacher_Name' => 'required',
            'Teacher_Email' => 'required|unique:teachers,email',
            'Teacher_Number' => 'required|unique:teachers,phone_number',
            'password' => 'required|confirmed', // 'confirmed' rule checks if 'password' matches 'password_confirmation'
            'school' => 'required', // 'confirmed' rule checks if 'password' matches 'password_confirmation'

        ]);
        $teacher = new Teacher;
        $teacher->name = $request->Teacher_Name;
        $teacher->email = $request->Teacher_Email;
        $teacher->phone_number = $request->Teacher_Number;
        $teacher->school = $request->school;
        $teacher->status = 0;
        $teacher->password = Hash::make($request->password);
        $teacher->save();
        return redirect()->route('teacher.login.page');
    }
    public function proupdate($id, Request $request)
    {
        $validated = $request->validate([
            'Teacher_Name' => 'required',
            'Teacher_Email' => 'required',
            'Teacher_Number' => 'required',
        ]);
        $teacher = Teacher::find($id);
        $teacher->name = $request->Teacher_Name;
        $teacher->email = $request->Teacher_Email;
        $teacher->phone_number = $request->Teacher_Number;
        $teacher->password = Hash::make($request->password);
        if (!empty($request->hasFile('profilepic'))) {
            if ($request->hasFile('profilepic')) {
                $image = 'profilepic_' . time() . '.' . $request->profilepic->extension();
                $request->profilepic->move(public_path('/uploads/register/'), $image);
                $image = "/uploads/register/" . $image;
            }
            $teacher->profilepic = $image;
        }
        $teacher->save();
        return redirect()->route('dashboard');
    }

    function getajaxcalenderdata(Request $request)
    {
        $fromDate = date('Y-m-d', strtotime($request->startDate));
        $toDate = date('Y-m-d', strtotime($request->endDate));

        $bookings = Attendance::where(function ($query) use ($fromDate, $toDate) {
            $query->where(function ($q) use ($fromDate, $toDate) {
                $q->whereDate('attendance_date', '<=', $fromDate)
                    ->whereDate('attendance_date', '>=', $fromDate);
            })->orWhere(function ($q) use ($fromDate, $toDate) {
                $q->whereDate('attendance_date', '<=', $toDate)
                    ->whereDate('attendance_date', '>=', $toDate);
            })->orWhere(function ($q) use ($fromDate, $toDate) {
                $q->whereDate('attendance_date', '>=', $fromDate)
                    ->whereDate('attendance_date', '<=', $toDate);
            });
        })->get();

        $user = Auth::guard('teacher')->user();
        $studentlist = Student::where('teacher_id', $user->id)->get();

        $statusarray = array();
        foreach ($studentlist as $singlestudent) {
            $singlearray = array();
            $singlearray['text'] = $singlestudent->name;
            $singlearray['id'] = $singlestudent->id;
            $singlearray['color'] = '#ff9747';
            $statusarray[] = $singlearray;
        }

        $bookingdataarray = array();

        foreach ($bookings as $singlebooking) {

            $bookingdataarraynew = array();
            if ($singlebooking->status == 1) {
                $bookingdataarraynew['text'] = 'P';
            } elseif ($singlebooking->status == 0) {
                $bookingdataarraynew['text'] = 'A';
            } else {
                $bookingdataarraynew['text'] = 'N/A';
            }

            $bookingdataarraynew['ownerId'] = $singlebooking->id;
            $bookingdataarraynew['startDate'] = date('Y-m-d 10:00:00', strtotime($singlebooking->attendance_date));
            $bookingdataarraynew['endDate'] = date('Y-m-d 16:00:00', strtotime($singlebooking->attendance_date));
            $bookingdataarraynew['priority'] = $singlebooking->student_id;
            $bookingdataarray[] = $bookingdataarraynew;
        }

        $resourcesData = array();
        foreach ($bookings as $singleproperty) {
            if ($singleproperty->status == 1) {
                $color = '#008000';
                $text = 'P';
            } elseif ($singleproperty->status == 0) {
                $color = 'red';
                $text = 'A';
            } else {
                $color = '#ffff';
                $text = 'N/A';
            }
            $single = array();
            $single['text'] = $text;
            $single['id'] = $singleproperty->id;
            $single['color'] = $color;
            $resourcesData[] = $single;
        }

        // print_r($resourcesData);die;
        echo json_encode(['resourcesData' => $resourcesData, 'priorityData' => $statusarray, 'bookingdata' => $bookingdataarray]);
        exit;
    }

    public function registertion()
    {
        $schools  = School::orderBy('id', 'desc')->get();
        $Bannerpojition = Banner::where('bannerpojition', 'Home Banner')->orderBy('id', 'DESC')->get();
        return view('registertion', compact('schools', 'Bannerpojition'));
    }
    public function studentadd()
    {
        $classes = SchoolClass::where('status', '1')->get();
        return view('front.students.add', compact('classes'));
    }

    public function myacount()
    {
        $user = Auth::guard('teacher')->user();
        return view('front.myacount', compact('user'));
    }
    public function logout()
    {
        Auth::guard('teacher')->logout();
        return redirect()->route('teacher.login.page');
    }
    public function changepass()
    {
        return view('front.password');
    }
    public function passedit(Request $req)
    {
        $req->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required',
        ]);

        $admin = Auth::guard('teacher')->user();
        if ($req->new_password !== $req->confirm_password) {
            return redirect()->back()->withErrors(['confirm_password' => 'New password and confirm password do not match.'])->withInput();
        }
        if (!Hash::check($req->old_password, $admin->password)) {
            return redirect()->back()->withErrors(['old_password' => 'The specified old password does not match the Old password'])->withInput();
        }
        $admin->password = Hash::make($req->new_password);
        $admin->save();
        return redirect()->route('teacher.dashboard')->with('success', 'Password changed successfully');
    }

    public function stustor(Request $request)
    {
        //dd($request->all());

        $validated = $request->validate([
            'Student_Name' => 'required',
            'class' => 'required',
        ]);
        $student = new Student;
        $student->name = $request->Student_Name;
        $student->class = $request->class;
        $user = Auth::guard('teacher')->user();
        $student->teacher_id = $user->id;
        $student->save();
        return redirect()->route('student');
    }
    public function studentedit($id, Request $request)
    {
        //dd($request->all());

        $validated = $request->validate([
            'Student_Name' => 'required',
            'class' => 'required',
        ]);
        $student = Student::find($id);
        $student->name = $request->Student_Name;
        $student->class = $request->class;
        $user = Auth::guard('teacher')->user();
        $student->teacher_id = $user->id;
        $student->save();
        return redirect()->route('student');
    }

    public function edit(Request $request)
    {
        $student_data = Student::find($request->id);
        $classes = SchoolClass::where('status', 1)->get();
        return view('front.students.edit', compact('student_data', 'classes'));
    }

    public function student(Request $request)
    {
        $user = Auth::guard('teacher')->user();
        if ($request->ajax()) {
            $students = Student::where('teacher_id', $user->id)->orderBy('id', 'DESC')->get();
            return Datatables::of($students)->addIndexColumn()->addColumn('action', function ($row) {
                $actionBtn = '<a href="' . route('editstu', ['id' => $row->id]) . '" class="edit btn btn-success btn-sm">Edit</a>
  <a href="' . route('delete', ['id' => $row->id]) . '" class="deletebtn btn btn-danger btn-sm ">Delete</a>';
                return $actionBtn;
            })->addColumn('status', function ($row) {
                if ($row->status == 1) {
                    $status = '<span class="badge bg-success">Active</span>';
                } else {
                    $status = '<span class="badge bg-danger">Inactive</span>';
                }
                return $status;
            })->addColumn('class', function ($row) {
                $classid = Student::where('id', $row->id)->pluck('class')->first();
                $classname = SchoolClass::where('id', $classid)->pluck('class_name')->first();
                return $classname;
            })->rawColumns(['action', 'status'])->make(true);
        }
        return view('front.students.index');
    }

    public function delete($id)
    {

        Student::find($id)->delete();
        return redirect()->back()->with('success', 'Student successfully delete');
    }
}
