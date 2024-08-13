<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use App\Models\TeacherClass;
use App\Models\Teacher;
use App\Models\Document;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $students = Student::orderBy('id', 'DESC')->get();
            return Datatables::of($students)->addIndexColumn()->addColumn('action', function ($row) {
                $actionBtn = '<a href="' . route('edit.student.form', ['id' => $row->id]) . '" class="edit btn btn-success btn-sm">Edit</a>
  <a href="' . route('stu.delete', ['id' => $row->id]) . '" class="deletebtn btn btn-danger btn-sm ">Delete</a>';
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
        return view('admin.students.index');
    }
    public function addform()
    {
        $classes = SchoolClass::where('status', '1')->get();
        $Teacher = Teacher::orderBy('id', 'desc')->get();
        return view('admin.students.add', compact('classes', 'Teacher'));
    }

    public function editform(Request $request)
    {

        $student_data = Student::find($request->id);
        $classes = SchoolClass::where('status', 1)->get();
        $subjectids = $student_data->subjects ? json_decode($student_data->subjects) : [];
        $subjects = Subject::whereIn('id', $subjectids)->where('status', 1)->get();
        $documents = Document::where('holder_type', 2)->where('holder_id', $request->id)->get();
        $Teacher = Teacher::orderBy('id', 'desc')->get();
        return view('admin.students.edit', compact('student_data', 'classes', 'subjects', 'documents', 'Teacher'));
    }

    public function classsubjects(Request $request)
    {
        $subjects = SchoolClass::find($request->id);
        $idsArray = explode(',', $subjects->subjects);
        $subjects = Subject::whereIn('id', $idsArray)->where('status', '1')->get();
        $subjectname = null;
        foreach ($subjects as $subject) {
            $subjectname .= '<option value="' . $subject->id . '" selected> ' . $subject->subject_name . '</option>';
        }
        return $subjectname;
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'Student_Name' => 'required',
            'student_class' => 'required',
            'status' => 'required',
            'teacher_id' => 'required',
        ]);
        $student = new Student;
        $student->name = $request->Student_Name;
        $student->teacher_id = $request->teacher_id;
        $student->status = $request->status;
        $student->class = $request->student_class;
        $student->save();
        return redirect()->route('students.index');
    }
    public function edit(Request $request)
    {
        $validated = $request->validate([
            'Student_Name' => 'required',
            'student_class' => 'required',
            'status' => 'required',
            'teacher_id' => 'required',
        ]);
        $student = Student::find($request->student_id);
        $student->name = $request->Student_Name;
        $student->teacher_id = $request->teacher_id;
        $student->status = $request->status;
        $student->class = $request->student_class;
        $student->save();
        return redirect()->route('students.index');
    }

    public function delete($id)
    {

        Student::find($id)->delete();
        return redirect()->back()->with('success', 'Teacher successfully delete');
    }
}
