<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use App\Models\Page;
use App\Models\Booking;
use App\Models\Operator;
use Illuminate\Support\Str;
use App\Models\FleetDetails;
use Illuminate\Http\Request;

class OperatorAdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }
    public function getMenus()
    {
        $currCountry = request()->segment(1);
        $menus = [
            'header_menus' => '',
            'footer_menus' => ''
        ];

        $pages = Page::where(['country' => $currCountry, 'status' => '1'])->get();

        if ($pages) {
            $menus['header_menus'] = $pages->where('header', '1');
            $menus['footer_menus'] = $pages->where('footer', '1');
        }
        return $menus;
    }
    public function getAdminAllOperator(Request $request)
    {
        // return$request;
        $currCountry = request()->segment(2);
        $listing_count = $this->perpage;
        $search_key = "";
        if ($request->search_key) {
            $search_key = $request->search_key;
        }
        $operators = Operator::where(['country' => $currCountry])
            ->where(function ($query) use ($search_key) {
                if ($search_key != "") {
                    return $query->orWhere('first_name', 'LIKE', '%' . $search_key . '%');
                }
            })
            ->orderBy('id', 'desc')
            ->paginate($listing_count);

        $bundle = ['operators' => $operators];

        if (Request()->ajax()) {
            return response()->json(view('Admin.operatorTable', $bundle)->render());
        }

        return view('Admin.operator', $bundle);
    }

    public function viewOperator(Request $request, $id)
    {

        $operator = Operator::where(['id' => $id])->first();

        $currCountry = request()->segment(2);
        $listing_count = $this->perpage;

        $search_key = "";
        if ($request->search_key) {
            $search_key = $request->search_key;
        }

        // Booking List
        $query = Booking::where(['country' => $currCountry])
            ->where(function ($query) use ($search_key) {
                if ($search_key != "") {
                    return $query->orWhere('id', 'LIKE', '%' . $search_key . '%')
                        ->orWhere('start', 'LIKE', '%' . $search_key . '%')
                        ->orWhere('end', 'LIKE', '%' . $search_key . '%');
                }
            })
            ->where('operator_id', $id)
            ->with('user')
            ->with('vehicle')
            ->orderBy('id', 'desc');

        $bookings = $query->paginate($listing_count);
        $bundle = ['bookings' => $bookings, 'statuss' => $this->bookingStatus];
        if (Request()->ajax()) {
            return response()->json(view('Admin.bookingsTable', $bundle)->render());
        }

        $data = [
            'title' => 'Operator Details',
            'operator' => $operator,
            'bookings' => $bookings,
            'statuss' => $this->bookingStatus
        ];
        if ($operator) {
            return view('Admin.viewOperator', $data);
        } else {
            return view('Admin.page_404');
        }
    }

    public function changeOperatorStatus(Request $request)
    {
        if (isset($request->status)) {
            Operator::where(['id' => $request->id])->update(['status' => $request->status]);
        }

        if (isset($request->is_approved)) {
            Operator::where(['id' => $request->id])->update(['is_approved' => $request->is_approved]);
        }

        return redirect()->back();
    }

    public function addOperator(Request $request)
    {
        $page_id = null;
        // dd($request->page_id);
        if ($request->page_id) {
            $page_id = $request->page_id;
        }
        $page = new Page();
        if ($page_id) {
            $operator = Operator::where(['id' => $page_id])->first();
        }
        if ($operator) {
            // $page_types = $this->page_types;
            return view('Admin.addOperator', ['page' => $page, 'operator' => $operator]);
        } else {
            return view('Admin.page_404');
        }
    }

    public function saveOperator(Request $request)
    {

        $validatedData = $request->validate([
            'email'    => "required|email|max:100|unique:operators,email," . $request->id . ",id",
            'office_email' => 'required|email',
            'first_name' => 'required|string|max:255',
            'sur_name' => 'required|string|max:255',
            'cab_operator_name' => 'required|string|max:255',
            'legal_company_name' => 'required|string|max:255',
            'office_phone_number' => 'required|string|max:20',
            'postcode' => 'required|string|max:10',
            'website' => 'required',
            'licensing_local_authority' => 'required|string|max:255',
            'private_hire_operator_licence_number' => 'required|string|max:255',
            'licence_expiry_date' => 'required|date',
            'fleet_size' => 'required|string|max:255',
            'dispatch_system' => 'required|string|max:255',
            'authorised_contact_person' => 'required|string|max:255',
            'authorised_contact_email_address' => 'required|email',
            'authorised_contact_mobile_number' => 'required|string|max:20',
            'about_us' => 'required|string|max:255',
            'revenue' => 'required|string|max:255',
            'status' => 'required',
            'is_approved' => 'required',
            'upload_operator_licence' => 'file|mimes:pdf,jpg,png',
            'upload_public_liability_Insurance' => 'file|mimes:pdf,jpg,png',
        ]);

        // dd($request->all());
        // $validatedData['password'] = Hash::make($validatedData['password']);

        if ($request->hasFile('upload_operator_licence')) {
            $fileName = $this->fileUpload($request, "upload_operator_licence", $this->OperatorLicencePath);
            if ($fileName != "") {
                $validatedData['upload_operator_licence'] = $fileName;
            }
        }

        if ($request->hasFile('upload_public_liability_Insurance')) {
            $fileName = $this->fileUpload($request, "upload_public_liability_Insurance", $this->OperatorLicencePath);
            if ($fileName != "") {
                $validatedData['upload_public_liability_Insurance'] = $fileName;
            }
        }

        $operator = Operator::updateOrCreate([
            'id' => $request->id
        ], $validatedData);

        $fleetTypes = implode(',', $request->input('fleet_type', []));

        FleetDetails::updateOrCreate(
            [
                'operator_id' => $operator->id
            ],
            [
                'licensing_local_authority' => $validatedData['licensing_local_authority'],
                'private_hire_operator_licence_number' => $validatedData['private_hire_operator_licence_number'],
                'licence_expiry_date' => $validatedData['licence_expiry_date'],
                'fleet_size' => $validatedData['fleet_size'],
                'fleet_type' => $fleetTypes,
                'dispatch_system' => $validatedData['dispatch_system'],
            ]
        );

        return redirect()->back()->with('success', 'Operator Updated Successfully');
    }

    public function createPage(Request $request)
    {
        $currCountry = request()->segment(2);
        $page_id = null;
        $title = "";
        if ($request->page_id) {
            $page_id = $request->page_id;
        }
        $page_type = "";
        if ($request->name) {
            if (!$request->page_type) {
                $page_name = $request->name;
                $request['page_type'] = Str::slug($page_name, '-');
            }
        }

        $success = 0;
        $message = "unable to Add Page, Something went wrong!";
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'page_type' => 'required|unique:pages,page_type,' . $page_id . ',id,country,' . $currCountry,
        ]);
        if ($validator->fails()) {
            $success = 0;
            return  back()->withErrors($validator)->withInput();
        } else {
            $insert_data = $request->except(['imageName', 'bannerImage']);
            $insert_data['country'] = $currCountry;
            if (!$request->bannerImage) {
                $insert_data['image'] = null;
            }
            if (!$request->imageName) {
                $insert_data['side_app_image'] = null;
            }
            if ($request->image) {
                $fileName = $this->fileUpload($request, "image", $this->pagePath);
                if ($fileName != "") {
                    $insert_data['image'] = $fileName;
                }
            }
            if ($request->side_app_image) {
                $fileName = $this->fileUpload($request, "side_app_image", $this->pagePath);
                if ($fileName != "") {
                    $insert_data['side_app_image'] = $fileName;
                }
            }
            $page = Page::updateOrCreate(['id' => $page_id], $insert_data);
            if ($page) {
                $success = 1;
                $message = "Page added successfully !";
            }
        }
        if ($success) {
            return redirect()->route('admin.pages')->with('success', $message);
        } else {
            return redirect()->back()->withErrors([$message]);
        }
    }
}
