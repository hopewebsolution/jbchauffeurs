<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\SidebarBlock;
use App\Models\BookWithUs;
use App\Models\Slider;
use App\Models\Service;
use App\Models\Page;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}
    public function home(Request $request)
    {
        $currCountry = request()->segment(1);
        $sliders = Slider::where(['country' => $currCountry])
            ->orderBy('id', 'desc')
            ->get();
        $sidebarBlock = SidebarBlock::where(['country' => $currCountry, 'is_home' => '1', 'status' => '1'])
            ->get()->groupBy('type');
        $textBlocks = null;
        $appBlocks = null;
        if ($sidebarBlock) {
            if (isset($sidebarBlock['text'])) {
                $textBlocks = $sidebarBlock['text'];
            }
            if (isset($sidebarBlock['app'])) {
                $appBlocks = $sidebarBlock['app'];
            }
        }
        $services = Service::where(['country' => $currCountry, 'is_home' => '1'])
            ->orderBy('id', 'desc')
            ->get();
        $pageData = Page::where(["country" => $currCountry, "page_type" => "home"])->first();
        if (!$pageData) {
            $pageData = new Page();
        }
        return view('home', ['sliders' => $sliders, 'services' => $services, 'pageData' => $pageData, 'textBlocks' => $textBlocks, 'appBlocks' => $appBlocks]);
    }
    public function aboutUs(Request $request)
    {
        $currCountry = request()->segment(1);
        $pageData = Page::where(["country" => $currCountry, "page_type" => "about-us"])->first();
        $bookWithUs = BookWithUs::where(["country" => $currCountry])->get();
        if (!$pageData) {
            $pageData = new Page();
        }
        return view('aboutUs', ['pageData' => $pageData, 'bookWithUs' => $bookWithUs]);
    }
    public function privacyPolicy(Request $request)
    {
        $currCountry = request()->segment(1);
        $pageData = Page::where(["country" => $currCountry, "page_type" => "privacy"])->first();
        if (!$pageData) {
            $pageData = new Page();
        }
        return view('privacyPolicy', ['pageData' => $pageData]);
    }
    public function termsConditions(Request $request)
    {
        $currCountry = request()->segment(1);
        $pageData = Page::where(["country" => $currCountry, "page_type" => "terms-conditions"])->first();
        //dd($pageData);
        if (!$pageData) {
            $pageData = new Page();
        }
        return view('termsConditions', ['pageData' => $pageData]);
    }
    public function customerTerms(Request $request)
    {
        $currCountry = request()->segment(1);
        $pageData = Page::where(["country" => $currCountry, "page_type" => "customer-terms"])->first();
        if (!$pageData) {
            $pageData = new Page();
        }
        return view('pageTemplate', ['pageData' => $pageData]);
    }
    public function cmsPage(Request $request)
    {


        $currCountry = request()->segment(1);
        $page_type = $request->page_slug;
        $pageData = Page::where(["country" => $currCountry, "page_type" => $page_type])->first();
        if ($pageData) {
            if ($page_type == "home") {
                return redirect()->route('user.home');
            } else if ($page_type == "about-us") {
                return redirect()->route('user.about');
            } else if ($page_type == "airports") {
                return redirect()->route('user.airportTrans');
            } else if ($page_type == "how-it-works") {
                return redirect()->route('user.howItWorks');
            } else if ($page_type == "how-it-work") {
                return redirect()->route('operator.howItWorks');
            } else if ($page_type == "faq") {
                return redirect()->route('user.faq');
            } else if ($page_type == "operator") {
                return redirect()->route('operator.login');
            } else if ($page_type == "contact-us") {
                return redirect()->route('user.contactUs');
            } else if ($page_type == "customer") {
                return redirect()->route('user.loginForm');
            } else {
                return view('pageTemplate', ['pageData' => $pageData]);
            }
        } else {
            return view('page_404');
        }
    }
}
