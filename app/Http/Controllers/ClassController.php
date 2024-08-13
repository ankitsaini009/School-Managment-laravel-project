<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;

class ClassController extends Controller
{
    public function index(Request $request)
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
        return view('admin.classes.index', compact('subjects'));
    }

    public function add(Request $request)
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

    public function delete($id)
    {
        $class = SchoolClass::find($id);
        $class->delete();
        return redirect()->back();
    }
    public function editdata(Request $request)
    {
        $class = SchoolClass::find($request->id);
        return json_encode($class);
    }
    public function edit(Request $request)
    {
        $class = SchoolClass::find($request->class_id);
        $user = Auth::guard('teacher')->user();
        $class->created_by = $user->name;
        $class->class_name = $request->class_name;
        $class->status = $request->status;
        $class->save();
        return redirect()->back();
    }
}
