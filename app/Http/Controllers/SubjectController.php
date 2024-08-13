<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherClass;
use Yajra\DataTables\DataTables;

class SubjectController extends Controller
{
   public function index(Request $request){
    if ($request->ajax()){
        $customers = Subject::orderBy('id','DESC')->get();
        return Datatables::of($customers)->addIndexColumn()->addColumn('action', function($row){
                $actionBtn = '<a href="javascript:void(0);" class="editsubject btn btn-success btn-sm" subjectid="'.$row->id.'">Edit</a>
                <a href="'.route('subject.delete',['id'=>$row->id]).'" class="btn btn-danger btn-sm">Delete</a>';
                return $actionBtn;
            })->addColumn('status',function($row){
               if($row->status == 1){
                   $status = '<span class="badge bg-success">Active</span>';
               }else{
                   $status = '<span class="badge bg-danger">Inactive</span>';
               }
               return $status;
           })->rawColumns(['action','status'])->make(true);
    }
    return view('admin.subjects.index');
   }
   public function add(Request $request){
    if(Subject::where('subject_name', $request->subject_name)->exists()){
        return redirect()->back()->with(['error'=>'This Subject Allredy Added']);
    }else{
        $subject = new Subject;
        $subject->subject_name = $request->subject_name;
        $subject->status = $request->status;
        $subject->save();
        return redirect()->back();
    }
   }
   public function delete($id){
        $subject = Subject::find($id);
        if(!is_null($subject)){
            $subject->delete();
        }
        return redirect()->back();
   }
   public function editdata(Request $request){
        $subject = Subject::find($request->id);
        return json_encode($subject);
   }
   public function edit(Request $request){
        $subject = Subject::find($request->subject_id);
        $subject->subject_name = $request->subject_name;
        $subject->status = $request->status;
        $subject->save();
        return redirect()->back();

   }

   public function teachersubjects(Request $request){
       $subjects = TeacherClass::where('holder_id',$request->teacher_id)->first();
        $subjectids = json_decode($subjects->subject_ids);
        $subjects = '';
        foreach($subjectids as $id){
            $subject = Subject::find($id);
            $subjects .= '<option value="'.$subject->id.'">'.$subject->subject_name.'</option>';
        }

        return $subjects;
   }
}
