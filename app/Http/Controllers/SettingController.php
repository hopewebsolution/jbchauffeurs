<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Validator;
use Auth;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }
    public function getAllSettings()
    {
        $currCountry = request()->segment(1);
        $settings = Setting::where(['country' => $currCountry])->first();
        if (!$settings) {
            $settings = new Setting();
        }
        return $settings;
    }
    public function AdmingetAllSettings()
    {
        $currCountry = request()->segment(2);

        $settings = Setting::where(['country' => $currCountry])->first();
        if (!$settings) {
            $settings = new Setting();
        }
        return $settings;
    }
    public function addSetting(Request $request)
    {
        $currCountry = request()->segment(2);
        $settings = Setting::where(['country' => $currCountry])->first();
        if (!$settings) {
            $settings = new Setting();
        }
        return view('Admin.addSettings', ['settings' => $settings]);
    }

    public function createSetting(Request $request)
    {
        $currCountry = request()->segment(2);
        $success = 0;
        $message = "unable to Add, Something went wrong!";
        $insert_data = array();
        $insert_data = [
            'country' => $currCountry,
            'slogantitle' => $request->slogantitle,
            'phone' => $request->phone,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'twitter' => $request->twitter,
            'linkedin' => $request->linkedin,
            'contact_phone' => $request->contact_phone,
            'map' => $request->map,
            'address' => $request->address,
            'waitCharge' => $request->waitCharge,
            'gst' => $request->gst,
            'tax_type' => $request->tax_type,
            'cardFee' => $request->cardFee,
            'maintenance' => $request->maintenance,
            'footer_text' => $request->footer_text,
            'book_with_title' => $request->book_with_title,
            'paypal_mode' => $request->paypal_mode,
            'paypal_sandbox_client_id' => $request->paypal_sandbox_client_id,
            'paypal_sandbox_client_secret' => $request->paypal_sandbox_client_secret,
            'paypal_live_client_id' => $request->paypal_live_client_id,
            'paypal_live_client_secret' => $request->paypal_live_client_secret,
            'admin_commission' => $request->admin_commission,
        ];

        if (!$request->logoName) {
            $insert_data['logo'] = null;
        }
        if ($request->logo) {
            $fileName = $this->fileUpload($request, "logo");
            if ($fileName != "") {
                $insert_data['logo'] = $fileName;
            }
        }
        if (!$request->header_imgName) {
            $insert_data['header_img'] = null;
        }
        if ($request->header_img) {
            $fileName = $this->fileUpload($request, "header_img");
            if ($fileName != "") {
                $insert_data['header_img'] = $fileName;
            }
        }

        $settings = Setting::upsert($insert_data, ['country'], $insert_data);

        if ($settings) {
            $success = 1;
            $message = "Setting added successfully !";
        }
        if ($success) {
            return redirect()->route('admin.settings')->with('success', $message);
        } else {
            return redirect()->back()->withErrors([$message]);
        }
    }
}
