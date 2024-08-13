<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\SchoolClass;
use App\Models\Subject;
use PhpParser\Node\Expr\FuncCall;

class SchoolController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $students = School::orderBy('id', 'DESC')->get();
            return Datatables::of($students)->addIndexColumn()->addColumn('action', function ($row) {
                $actionBtn = '<a href="' . route('edit', ['id' => $row->id]) . '" class="edit btn btn-success btn-sm">Edit</a>
  <a href="' . route('delete', ['id' => $row->id]) . '" class="deletebtn btn btn-danger btn-sm ">Delete</a>';
                return $actionBtn;
            })->rawColumns(['action', 'status'])->make(true);
        }
        return view('admin.school.index');
    }
    public function schooladd()
    {
        return view('admin.school.add');
    }
    public function edit(Request $request)
    {
        $School = School::find($request->id);
        return view('admin.school.edit', compact('School'));
    }

    public function stoschool(Request $request)
    {
        //dd($request->all());
        $validated = $request->validate([
            'name' => 'required',
        ]);

        $class = new School;
        $class->name = $request->name;
        $class->description = $request->address;
        $class->save();
        return redirect()->route('schoolopen');
    }
    public function updatesch($id, Request $request)
    {
        //dd($request->all());
        $validated = $request->validate([
            'name' => 'required',
        ]);

        $class = School::find($id);
        $class->name = $request->name;
        $class->description = $request->address;
        $class->save();
        return redirect()->route('schoolopen');
    }

    public function delete($id)
    {

        School::find($id)->delete();
        return redirect()->back()->with('success', 'Student successfully delete');
    }
}
