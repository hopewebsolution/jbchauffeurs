<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use Validator;
use Auth;
use Illuminate\Support\Str;

class PageController extends Controller
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
    public function getAdminAllPages(Request $request)
    {
        $currCountry = request()->segment(2);
        $listing_count = $this->perpage;
        $search_key = "";
        if ($request->search_key) {
            $search_key = $request->search_key;
        }
        $pages = Page::where(['country' => $currCountry])
            ->where(function ($query) use ($search_key) {
                if ($search_key != "") {
                    return $query->orWhere('name', 'LIKE', '%' . $search_key . '%');
                }
            })
            ->orderBy('id', 'desc')
            ->paginate($listing_count);
        $bundle = ['pages' => $pages];
        if (Request()->ajax()) {
            return response()->json(view('Admin.pagesTable', $bundle)->render());
        }
        return view('Admin.pages', $bundle);
    }
    public function addPage(Request $request)
    {
        $page_id = null;
        if ($request->page_id) {
            $page_id = $request->page_id;
        }
        $page = new Page();
        if ($page_id) {
            $page = Page::where(['id' => $page_id])->first();
        }
        if ($page) {
            $page_types = $this->page_types;
            return view('Admin.addPage', ['page' => $page, 'page_types' => $page_types]);
        } else {
            return view('Admin.page_404');
        }
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
