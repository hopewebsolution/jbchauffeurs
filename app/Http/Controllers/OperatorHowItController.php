<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Models\Service;
use App\Models\Page;

class OperatorHowItController extends Controller
{
    public function operatorhowItWorks(Request $request){

        $listing_count= $this->perpage;
        $currCountry = request()->segment(1);
        $services=Service::where(['country'=>$currCountry,'is_home'=>'0'])
                    ->orderBy('id','desc')
                    ->paginate($listing_count);
        $pageData=Page::where(["country"=>$currCountry,"page_type"=>"how-it-work"])->first();
        if(!$pageData){
            $pageData=new Page();
        }
        return view('operatorhowItWorks',['services'=>$services,'pageData'=>$pageData]);
    }
}
