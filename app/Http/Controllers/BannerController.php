<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Bannerpojition;
use DataTables;

class BannerController extends Controller
{
    public function index()
    {
        if (\request()->ajax()) {
            $data = Banner::latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    return '<img src="' . asset($row->image) . '" alt="' . $row->name . '" width="100">';
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('banners.edit', $row->id) . '" class="edit btn btn-success btn-sm">Edit</a> <a href="' . route('banners.delete', $row->id) . '" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }
        return view('admin.banners.index');
    }

    public function add()
    {
        $Bannerpojition = Bannerpojition::orderBy('id', 'DESC')->get();
        return view('admin.banners.add', compact('Bannerpojition'));
    }

    public function store(Request $req)
    {
        $req->validate([
            'name' => 'required',
            'description' => 'required',
            'bannerpojition' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg',
        ]);

        $bannerdata = new Banner;
        $bannerdata->name = $req->name;
        $bannerdata->description = $req->description;
        $bannerdata->bannerpojition = $req->bannerpojition;

        if (!empty($req->hasFile('image'))) {
            if ($req->hasFile('image')) {
                $image = 'banner_' . time() . '.' . $req->image->extension();
                $req->image->move(public_path('/uploads/register/'), $image);
                $image = "/uploads/register/" . $image;
            }
            $bannerdata->image = $image;
        }
        if ($bannerdata->save()) {
            return redirect()->route('banners')->with('success', 'Banner successfully add');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error in Banner add. Please try again');
        }
    }


    public function edit($id)
    {
        $getbanner = Banner::findOrFail($id);
        $Bannerposition = Bannerpojition::orderBy('id', 'DESC')->get();
        return view('admin.banners.edit', compact('getbanner', 'Bannerposition'));
    }

    public function update($id, Request $req)
    {
        $bannerdata = Banner::find($id);
        $bannerdata->name = $req->name;
        $bannerdata->description = $req->description;
        $bannerdata->bannerpojition = $req->bannerpojition;

        if (!empty($req->hasFile('image'))) {
            if ($req->hasFile('image')) {
                $image = 'banner_' . time() . '.' . $req->image->extension();
                $req->image->move(public_path('/uploads/register/'), $image);
                $image = "/uploads/register/" . $image;
            }
            $bannerdata->image = $image;
        }
        if ($bannerdata->save()) {
            return redirect()->route('banners')->with('success', 'Banner successfully add');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error in Banner add. Please try again');
        }
    }

    public function delete($id)
    {
        Banner::find($id)->delete();
        return redirect()->route('banners')->with('success', 'Banner successfully delete');
    }
}
