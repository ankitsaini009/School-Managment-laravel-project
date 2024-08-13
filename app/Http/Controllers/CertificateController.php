<?php

namespace App\Http\Controllers;

use App\Models\Addtext;
use Illuminate\Http\Request;
use App\Models\Certificate;
use App\Models\SchoolClass;
use App\Models\Student;
use Yajra\DataTables\DataTables;
use App\Models\ReleasedCertificate;
use Illuminate\Support\Facades\File;
use App\Models\Period;
use App\Models\TimeTableConfigartion;

class CertificateController extends Controller
{

    public function releasecertificatesindex(Request $request)
    {
        if ($request->ajax()) {
            $customers = ReleasedCertificate::orderBy('id', 'DESC')->get();
            return Datatables::of($customers)->addIndexColumn()->addColumn('action', function ($row) {
                $actionBtn = '<a href="' . route('edit.release.certificate.form', ['id' => $row->id]) . '" class="edit btn btn-success btn-sm">Edit</a>
                    <a href="javascript:void(0)" class="deletebtn btn btn-danger btn-sm ">Delete</a>';
                return $actionBtn;
            })->addColumn('Holder_Name', function ($row) {
                $name = Student::find($row->holder_id);
                return $name->name;
            })->addColumn('Image', function ($row) {
                $image = ' <a href="' . asset('storage/releasecertificates/' . $row->certificate) . '" target="_blank">
                <img src="' . asset('storage/releasecertificates/' . $row->certificate) . '" alt="" style="width:200px;">
              </a>';
                return $image;
            })->addColumn('status', function ($row) {
                return 'Relesed';
            })->rawColumns(['action', 'Image', 'Holder_Name', 'status'])->make(true);
        }
        return view('admin.certificates.releaseindex');
    }

    public function charactercertificatedata(Request $request)
    {
        $certificate = Certificate::find($request->certificate_id);
        $student = Student::find($request->student_id);
        $class = SchoolClass::find($student->class);
        $newdiscription = str_replace(['[HOLDER_NAME]', '[HOLDER_PARENT]', '[HOLDER_CLASS]', '[HOLDER_SCHOLL]'], [ucwords($student->name), ucwords($student->father_name), $class->class_name, 'S.B.V.M SCHOOL'], $certificate->certificate_discription);

        return $newdiscription;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $customers = Certificate::orderBy('id', 'DESC')->get();
            return Datatables::of($customers)->addIndexColumn()->addColumn('action', function ($row) {
                $actionBtn = '<a href="' . route('certificate.edit.form', ['id' => $row->id]) . '" class="edit btn btn-success btn-sm">Edit</a>
                    <a href="javascript:void(0)" class="deletebtn btn btn-danger btn-sm">Delete</a>';
                return $actionBtn;
            })->addColumn('template', function ($row) {
                $template = ' <a href="' . asset('storage/certificates/' . $row->certificate_temp_path) . '" target="_blank">
                   <img src="' . asset('storage/certificates/' . $row->certificate_temp_path) . '" alt="" style="width:200px;">
                 </a>';
                return $template;
            })->addColumn('status', function ($row) {
                if ($row->status == 1) {
                    $status = '<span class="badge bg-success">Active</span>';
                } else {
                    $status = '<span class="badge bg-danger">Inactive</span>';
                }
                return $status;
            })->rawColumns(['action', 'status', 'template'])->make(true);
        }
        return view('admin.certificates.index');
    }

    public function addform()
    {
        return view('admin.certificates.add');
    }

    public function editform(Request $request)
    {
        $certificate = Certificate::find($request->id);
        return view('admin.certificates.edit', compact('certificate'));
    }
    public function add(Request $request)
    {
        $validated = $request->validate([
            'Certificate_Name' => 'required',
            'Certificate_Template' => 'required',
            'Certificate_Discription' => 'required',
            'Discription_Color' => 'required',
            'status' => 'required',
            'name_font' => 'required',
            'Discription_Font' => 'required',
        ]);
        if (Certificate::where('certificate_name', $request->Certificate_Name)->exists()) {
            return redirect()->back()->with(['error' => 'This Cretificate Allredy Added']);
        } else {
            $certificate = new Certificate;
            if (!is_null($request->file('Certificate_Template'))) {
                $ext =  $request->file('Certificate_Template')->getClientOriginalExtension();
                $filename = 'Certificate_tamp_' . rand() . '.' . $ext;
                $request->file('Certificate_Template')->storeAs('public/certificates', $filename);
                $certificate->certificate_temp_path = $filename;
            }
            if (!is_null($request->file('Discription_Font'))) {
                $ext =  $request->file('Discription_Font')->getClientOriginalExtension();
                $filename = 'Discription_Font_' . rand() . '.' . $ext;
                $request->file('Discription_Font')->storeAs('public/certificates/font', $filename);
                $certificate->discription_font_path = $filename;
            }
            if (!is_null($request->file('name_font'))) {
                $ext =  $request->file('name_font')->getClientOriginalExtension();
                $filename = 'Name_Font_' . rand() . '.' . $ext;
                $request->file('name_font')->storeAs('public/certificates/font', $filename);
                $certificate->name_font_path = $filename;
            }
            $certificate->certificate_name = $request->Certificate_Name;
            $certificate->status = $request->status;
            $certificate->certificate_discription = $request->Certificate_Discription;
            $certificate->discription_color = $request->Discription_Color;
            $certificate->save();
            return redirect()->route('certificate.index');
        }
    }
    public function editcertificate(Request $request)
    {
        $certificate = Certificate::find($request->id);
        if (!is_null($request->file('Certificate_Template'))) {
            if (File::exists('storage/certificates/' . $certificate->certificate_temp_path)) {
                File::delete("storage/certificates/" . $certificate->certificate_temp_path);
            }
            $ext =  $request->file('Certificate_Template')->getClientOriginalExtension();
            $filename = 'Certificate_tamp_' . rand() . '.' . $ext;
            $request->file('Certificate_Template')->storeAs('public/certificates', $filename);
            $certificate->certificate_temp_path = $filename;
        }
        if (!is_null($request->file('Discription_Font'))) {
            if (File::exists('storage/certificates/font/' . $certificate->discription_font_path)) {
                File::delete("storage/certificates/font/" . $certificate->discription_font_path);
            }
            $ext =  $request->file('Discription_Font')->getClientOriginalExtension();
            $filename = 'Discription_Font_' . rand() . '.' . $ext;
            $request->file('Discription_Font')->storeAs('public/certificates/font', $filename);
            $certificate->discription_font_path = $filename;
        }
        if (!is_null($request->file('name_font'))) {
            if (File::exists('storage/certificates/font/' . $certificate->name_font_path)) {
                File::delete("storage/certificates/font/" . $certificate->name_font_path);
            }
            $ext =  $request->file('name_font')->getClientOriginalExtension();
            $filename = 'Name_Font_' . rand() . '.' . $ext;
            $request->file('name_font')->storeAs('public/certificates/font', $filename);
            $certificate->name_font_path = $filename;
        }
        $certificate->certificate_name = $request->Certificate_Name;
        $certificate->status = $request->status;
        $certificate->certificate_discription = $request->Certificate_Discription;
        $certificate->discription_color = $request->Discription_Color;
        $certificate->save();
        return redirect()->route('certificate.index');
    }

    public function releaseform()
    {
        $certificates = Certificate::where('status', 1)->get();
        $students = Student::where('status', 1)->get();
        return view('admin.certificates.releaseform', compact('certificates', 'students'));
    }

    public function editreleaseform(Request $request)
    {
        $certificates = Certificate::where('status', 1)->get();
        $students = Student::where('status', 1)->get();
        $releasecertificate = ReleasedCertificate::find($request->id);
        $addedtexts = Addtext::where('holder_id', $releasecertificate->holder_id)->get();
        return view('admin.certificates.releaseeditform', compact('releasecertificate', 'certificates', 'students', 'addedtexts'));
    }
    public function deleteitem(Request $request)
    {
        if ($request->name == 'text_delete') {
            $text = Addtext::find($request->id);
            $text->delete();
            return 'done';
        }

        if ($request->name == 'certificate_img') {
            unlink(public_path('storage/releasecertificates/' . $request->id));
            return 'done';
        }

        if ($request->name == 'period_delete') {
            $period = Period::find($request->id);
            $period->delete();
            return 'done';
        }

        if ($request->name == 'period_teacher_delete') {
            $config = TimeTableConfigartion::find($request->id);
            $config->delete();
            return 'done';
        }
    }
}
