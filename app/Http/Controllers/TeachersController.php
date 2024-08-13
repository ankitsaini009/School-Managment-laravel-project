<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use Yajra\DataTables\DataTables;
use App\Models\Subject;
use App\Models\SchoolClass;
use App\Models\Document;
use App\Models\School;
use App\Models\TeacherClass;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class TeachersController extends Controller
{
        public function index(Request $request)
        {
                if ($request->ajax()) {
                        $customers = Teacher::orderBy('id', 'DESC')->get();
                        return Datatables::of($customers)->addIndexColumn()->addColumn('action', function ($row) {
                                $actionBtn = '<a href="' . route('teacher.edit.form', ['id' => $row->id]) . '" class="edit btn btn-success btn-sm">Edit</a>
              <a href="' . route('teacher.delete', ['id' => $row->id]) . '" class="deletebtn btn btn-danger btn-sm deleteteacher" teacher_id="' . $row->id . '">Delete</a>';
                                return $actionBtn;
                        })->addColumn('status', function ($row) {
                                if ($row->status == 1) {
                                        $status = '<span class="badge bg-success">Active</span>';
                                } else {
                                        $status = '<span class="badge bg-danger">Inactive</span>';
                                }
                                return $status;
                        })->rawColumns(['action', 'status'])->make(true);
                }
                return view('admin.teachers.index');
        }

        public function delete($id)
        {

                Teacher::find($id)->delete();
                return redirect()->back()->with('success', 'Teacher successfully delete');
        }

        public function addform()
        {
                $classes = SchoolClass::orderBy('id', 'desc')->get();
                $subjects = Subject::where('status', '1')->get();
                $schools = School::orderBy('id', 'desc')->get();
                return view('admin.teachers.add', compact('subjects', 'classes', 'schools'));
        }

        public function add(Request $request)
        {
                $validated = $request->validate([
                        'Teacher_Name' => 'required',
                        'Teacher_Email' => 'required|email|unique:teachers,email',
                        'subjects' => 'required',
                        'classes' => 'required',
                        'Teacher_Number' => 'required|unique:teachers,phone_number',
                        'Teacher_Salary' => 'required',
                        'status' => 'required',
                        'password' => 'required',
                ]);
                $date = date('Y-m-d h:i:s', strtotime($request->delivered_on));
                $teacher = new Teacher;
                $teacher->name = $request->Teacher_Name;
                $teacher->email = $request->Teacher_Email;
                $teacher->status = $request->status;
                $teacher->salary = $request->Teacher_Salary;
                $teacher->school = $request->school;
                $teacher->phone_number = $request->Teacher_Number;
                $teacher->address = $request->address;
                $teacher->password = Hash::make($request->password);
                $teacher->save();

                $subjectarray = "[";
                foreach ($request->subjects as $subject) {
                        $subjectarray .= $subject;
                        $subjectarray .= ',';
                }
                $subjectarray = rtrim($subjectarray, ',');

                $subjectarray .= ']';
                $classarray = "[";
                foreach ($request->classes as $class) {
                        $classarray .= $class;
                        $classarray .= ',';
                }
                $classarray = rtrim($classarray, ',');
                $classarray .= ']';

                $teacher_class = new TeacherClass;
                $teacher_class->holder_id = $teacher->id;
                $teacher_class->subject_ids = $subjectarray;
                $teacher_class->class_ids = $classarray;
                $teacher_class->save();
                return redirect()->route('teachers.index');
        }
        public function editform(Request $request)
        {
                $teacher = Teacher::find($request->id);
                $documents = Document::where('holder_id', $request->id)->get();
                $subjects = Subject::where('status', '1')->get();
                $classes = SchoolClass::orderBy('id', 'desc')->get();
                $classes_subject = TeacherClass::where('holder_id', $request->id)->first();
                $schools = School::orderBy('id', 'desc')->get();

                if (!is_null($documents)) {
                        return view('admin.teachers.edit', compact('teacher', 'documents', 'classes_subject', 'subjects', 'classes', 'schools'));
                } else {
                        return view('admin.teachers.edit', compact('teacher', 'classes_subject', 'subjects', 'classes', 'schools'));
                }
        }
        public function edit(Request $request)
        {
                $teacher = Teacher::find($request->id);

                $teacher->name = $request->Teacher_Name;
                $teacher->status = $request->status;
                $teacher->email = $request->Teacher_Email;
                $teacher->salary = $request->Teacher_Salary;
                $teacher->school = $request->school;
                $teacher->phone_number = $request->Teacher_Number;
                if (!empty($request->password)) {
                        $teacher->password = Hash::make($request->password);
                }
                $teacher->address = $request->address;
                $teacher->save();

                $subjectarray = "[";
                foreach ($request->subjects as $subject) {
                        $subjectarray .= $subject;
                        $subjectarray .= ',';
                }
                $subjectarray = rtrim($subjectarray, ',');

                $subjectarray .= ']';

                if (!empty($request->classes)) {
                        $classarray = "[";
                        foreach ($request->classes as $class) {
                                $classarray .= $class;
                                $classarray .= ',';
                        }
                        $classarray = rtrim($classarray, ',');

                        $classarray .= ']';
                        $teacher_class = TeacherClass::where('holder_id', $request->id)->first();
                        $teacher_class->holder_id = $teacher->id;
                        $teacher_class->subject_ids = $subjectarray;
                        $teacher_class->class_ids = $classarray;
                        $teacher_class->save();
                }
                return redirect()->route('teachers.index');
        }

        public function classdata(Request $request)
        {
                $subjectIdsArray = $request->ids;
                $classes = SchoolClass::where(function ($query) use ($subjectIdsArray) {
                        foreach ($subjectIdsArray as $subjectId) {
                                $query->orWhere('subjects', 'like', "%$subjectId%");
                        }
                })->get();

                return $classes;
        }
}
