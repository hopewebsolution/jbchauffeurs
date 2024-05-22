<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Models\Service;
use App\Models\Page;

class HowItController extends Controller{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){

    }
    public function howItWorks(Request $request){
        $listing_count= $this->perpage;
        $currCountry = request()->segment(1);
        $services=Service::where(['country'=>$currCountry,'is_home'=>'0'])
                    ->orderBy('id','desc')
                    ->paginate($listing_count);
        $pageData=Page::where(["country"=>$currCountry,"page_type"=>"how-it-works"])->first();
        if(!$pageData){
            $pageData=new Page();
        }
        return view('howItWorks',['services'=>$services,'pageData'=>$pageData]);
    }
}
