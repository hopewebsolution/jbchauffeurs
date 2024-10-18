<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            $page = Page::with('sections')->where(['id' => $page_id])->first();
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
        if($request->page_type != "custom_page") {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'page_type' => 'required|unique:pages,page_type,' . $page_id . ',id,country,' . $currCountry,
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'page_type' => 'required',
            ]);
        }



        // dd($request);

        if ($validator->fails()) {
            $success = 0;
            return  back()->withErrors($validator)->withInput();
        } else {
            // try {
                //code...
                DB::beginTransaction();
                $insert_data = $request->except(['old_section_image', 'imageName', 'bannerImage', 'section_type', 'section_heading', 'section_id', 'section_type', 'section_image', 'section_btn_text', 'section_btn_link', 'section_content', 'use_section']);
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



                if($request->page_type == 'custom_page') {

                    $page->slug = Str::slug($page->name, '-');
                    $page->save();

                    $section_type = $request->section_type;
                    $section_id = $request->section_id;
                    $use_section = $request->use_section;
                    $section_heading = $request->section_heading;
                    $section_btn_text = $request->section_btn_text;
                    $section_btn_link = $request->section_btn_link;
                    $section_content = $request->section_content;

                    PageSection::where(['page_id' => $page->id])->delete();

                    // if ($request->hasFile('section_image')) {
                    //     $section_images = $request->file('section_image');
                    // }

                    foreach ($section_type as $key => $value) {
                        # code...
                        if($use_section[$key] == 1) {
                            $section = [
                                'page_id' => $page->id,
                                'section_type' => $value,
                                'section_heading' => $section_heading[$key],
                                'section_btn_text' => $section_btn_text[$key],
                                'section_btn_link' => $section_btn_link[$key],
                                'section_content' => $section_content[$key],
                                'use_section' => $use_section[$key],
                            ];

                            $fileName = '';
                            if ($request->has('section_image')) {
                                //

                                $section_image = $request->file('section_image');
                                if(isset($section_image[$key])){
                                    $fileName = time() . '_' . uniqid() . '.' . $section_image[$key]->getClientOriginalExtension();
                                    $destinationPath = public_path($this->pagePath);
                                    $section_image[$key]->move($destinationPath, $fileName);

                                    $section['section_image'] = $fileName;
                                } else {
                                    $section['section_image'] = $request->old_section_image[$key];
                                }
                            } else {
                                if(isset($request->old_section_image[$key])) {
                                    $section['section_image'] = $request->old_section_image[$key];
                                }

                            }

                            PageSection::updateOrCreate(['id' => $section_id[$key]], $section);
                        }
                    }

                }


                if ($page) {
                    $success = 1;
                    $message = "Page added successfully !";
                }

                DB::commit();
            // } catch (\Throwable $th) {
            //     //throw $th;
            //     DB::rollBack();
            //     $success = 0;
            //     $message = $th->getMessage();
            // }
        }
        if ($success) {
            return redirect()->route('admin.pages')->with('success', $message);
        } else {
            return redirect()->back()->withErrors([$message]);
        }
    }
}
