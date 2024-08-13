<?php

namespace App\Http\Controllers;
use App\Models\SchoolClass;
use App\Models\Teacher;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Period;
use App\Models\TimeTableConfigartion;

class TimeTableController extends Controller
{
    public function index(){
        $classes = SchoolClass::where('status',1)->get();
        $subjects = Subject::where('status',1)->get();
        $periods = Period::orderBy('start_on')->orderBy('end_on')->with('periodteacher')->get();
        $teachers = Teacher::where('status',1)->get();
        return view('admin.timetable.index',compact('classes','subjects','periods','teachers'));
    }
    public function addperiod(Request $request){
        date_default_timezone_set("Asia/Calcutta");
        $start_on = date("H:i:s", strtotime($request->start_on));
       $end_on = date("H:i:s", strtotime($request->end_on));
        $newperiod = new Period;
        $newperiod->name = $request->period_name;
        $newperiod->start_on = $start_on;
        $newperiod->end_on = $end_on;
        $newperiod->save();
        return redirect()->back();
    }

    public function assignteacher(Request $request){
        if(TimeTableConfigartion::where('teacher_id',$request->teacher)->where('period_id',$request->period_id)->where('class_id',$request->class_id)->exists()){
            return redirect()->back()->with(['error'=>'The Teacher Alredy Assigned!']);
        }else{

        }
        $newconfig = new TimeTableConfigartion;
        $newconfig->teacher_id = $request->teacher;
        $newconfig->period_id = $request->period_id;
        $newconfig->class_id = $request->class_id;
        $newconfig->subject_id = $request->subjects;
        $newconfig->save();
        return redirect()->back();
    }

}
