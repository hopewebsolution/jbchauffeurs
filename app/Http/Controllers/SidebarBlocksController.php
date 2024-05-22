<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SidebarBlock;
use Validator;
use Auth;
use Illuminate\Support\Str;

class SidebarBlocksController extends Controller{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){

    }
    public function deleteBlock(Request $request){
        $response=array();
        $success=0;
        $msg="Something went wrong,Please try again later!";
        if($request->id){
            $id=$request->id;
            $user=SidebarBlock::where(['id'=>$id])
                ->first();
            if($user){
                $user->forceDelete();
                $success=1;
                $msg="deleted successfully! ";
            }else{
                $success=0;
                $msg="invalid id to delete!";
            }
        }
        $response['success']=$success;
        $response['message']=$msg;
        return response()->json($response);
    }
    public function getSideBlocks(){
        $currCountry = request()->segment(1);
        $sidebarBlock=SidebarBlock::where(['country'=>$currCountry,'is_sidebar'=>'1','status'=>'1'])
                    ->get()->groupBy('type');
        return $sidebarBlock;
    }
    public function getAdminAllBlocks(Request $request){
        $currCountry = request()->segment(2);
        $listing_count= $this->perpage;
        $search_key="";
        if($request->search_key){
            $search_key=$request->search_key;
        }
        $sidebarBlocks=SidebarBlock::where(['country'=>$currCountry])
                    ->where(function($query) use ($search_key){
                        if($search_key!=""){
                            return $query->orWhere('title','LIKE','%'. $search_key .'%');
                        } 
                    })
                    ->orderBy('id','desc')
                    ->paginate($listing_count);
        $bundle=['sidebarBlocks'=>$sidebarBlocks];            
        if(Request()->ajax()){
            return response()->json(view('Admin.sideBlocksTable',$bundle)->render());
        }
        return view('Admin.sideBlocks',$bundle);
    } 
    public function addBlock(Request $request){
        $block_id=null;
        if($request->block_id){
            $block_id=$request->block_id;
        }
        $sidebarBlock=new SidebarBlock();
        if($block_id){
            $sidebarBlock=SidebarBlock::where(['id'=>$block_id])->first();
        }
        if($sidebarBlock){
            $page_types=$this->page_types;
            return view('Admin.addSidebarBlock',['sidebarBlock'=>$sidebarBlock]);
        }else{
            return view('Admin.page_404');
        }
    }
    public function createSidebarBlock(Request $request){
        $currCountry = request()->segment(2);
        $block_id=null;
        $title="";
        if($request->block_id){
            $block_id=$request->block_id;
        }
        
        $success=0;
        $message="unable to Add, Something went wrong!";
        
        //$insert_data=$request->except(['imageName']);
        $title=$request->title;
        $descriptions=$request->descriptions;
        $is_home=$request->is_home;
        $is_sidebar=$request->is_sidebar;
        $status=$request->status;
        $link=$request->link;
        $type=$request->type;
        $insert_data=[
            'country'=>$currCountry,
            'title'=>$title,
            'descriptions'=>$descriptions,
            'link'=>$link,
            'is_home'=>$is_home,
            'is_sidebar'=>$is_sidebar,
            'status'=>$status,
            'type'=>$type,
        ];
        if(!$request->imageName){
            $insert_data['image']=null;
        }
        $image="";
        if($request->image){
            $fileName=$this->fileUpload($request,"image",$this->blocksPath);
            if($fileName!=""){
                $insert_data['image']=$image=$fileName;
            } 
        }
        if($title!="" || $descriptions!="" || $image!=""){
            $sidebarBlock=SidebarBlock::updateOrCreate(['id' =>$block_id],$insert_data);
            if($sidebarBlock){
                $success=1;
                $message="sidebarBlock added successfully !";
            }
        }else{
            $success=0;
            $message="Please enter correct inputs!";
        }
        if($success){
            return redirect()->route('admin.sideBlocks')->with('success',$message); 
        }else{
            return redirect()->back()->withErrors([$message]);
        }
    }   
}
