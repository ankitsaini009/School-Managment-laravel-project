<?php

namespace App\Http\Controllers;

use App\Models\Sitesetting;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SiteSettingController extends Controller
{
    public function index()
    {
        $sitedata = Sitesetting::first();
        return view('admin.settings.index', compact('sitedata'));
    }
    public function updatesitesetting(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required',
            'site_email' => 'required',
            'site_contact' => 'required',
        ]);
        $site = Sitesetting::find(1);

        if ($request->hasFile('site_logo')) {
            $site_logo = 'site_logo_' . time() . '.' . $request->site_logo->extension();
            $request->site_logo->move(public_path('/uploads/register/'), $site_logo);
            $site_logo = "/uploads/register/" . $site_logo;
            $site->site_logo = $site_logo;
        }

        if ($request->hasFile('site_fav_icon')) {
            $site_fav_icon = 'site_fav_icon_' . time() . '.' . $request->site_fav_icon->extension();
            $request->site_fav_icon->move(public_path('/uploads/register/'), $site_fav_icon);
            $site_fav_icon = "/uploads/register/" . $site_fav_icon;
            $site->site_fav_icon = $site_fav_icon;
        }

        $site->site_name = $request->site_name;
        $site->site_email = $request->site_email;
        $site->site_contact = $request->site_contact;
        $site->site_address = $request->site_address;
        $site->header_code = $request->header_code;
        $site->footer_code = $request->footer_code;
        $site->save();

        return redirect()->back();
    }
    public function deletedoc(Request $request)
    {
        $doc = Document::find($request->id);
        if (!is_null($doc)) {
            if ($doc->holder_type == 1) {
                if (File::exists('storage/teachers/' . $doc->document_file)) {
                    File::delete("storage/teachers/" . $doc->document_file);
                }
                $doc->delete();
                return 'success';
            }

            if ($doc->holder_type == 2) {
                if (File::exists('storage/students/' . $doc->document_file)) {
                    File::delete("storage/students/" . $doc->document_file);
                }
                $doc->delete();
                return 'success';
            }
        } else {
            return 'error';
        }
    }
}
