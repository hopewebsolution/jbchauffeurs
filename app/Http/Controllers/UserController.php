<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\Hash;
use App\Mail\AdminNotify;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller{    
    public function __construct(){

    }
    public function deleteUser(Request $request){
        $response=array();
        $success=0;
        $msg="Something went wrong,Please try again later!";
        if($request->id){
            $id=$request->id;
            $user=User::where(['id'=>$id])
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
    public function apiUpdateStatus(Request $request){
        $response=array();
        $success=0;
        $message="unable to change, Something went wrong!";
        $validator = Validator::make($request->all(), [
            'user_id'=>'required',
            'status'=>'required',
        ]);
        if($validator->fails()){
            $success=0;
            $message=$validator->messages()->all()[0];
        }else{
            $user_id=$request->user_id;
            $status=$request->status;
            $user=User::where(['id'=>$user_id])->first();
            if($user){
                $user->status=$status;
                $user->save();
                $success=1;
                $message="status Updated successfully!";
            }else{
                $success=0;
                $message="Invalid id!";
            }
            
        }
        $response['success']=$success;
        $response['message']=$message;
        return response()->json($response);
    }
    public function getUsers(Request $request){
        $listing_count= $this->perpage;
        $search_key="";
        $user_id="";
        if($request->search_key){
            $search_key=$request->search_key;
        }
              
        $users=User::
                    where(function($query) use ($search_key){
                        if($search_key!=""){
                            return $query->orWhere('fname','LIKE','%'. $search_key .'%')
                                        ->orWhere('lname','LIKE','%'. $search_key .'%')
                                        ->orWhere('email','LIKE','%'. $search_key .'%')
                                        ->orWhere('phone','LIKE','%'. $search_key .'%')
                                        ->orWhere('mobile','LIKE','%'. $search_key .'%');
                        } 
                    })
                    ->orderBy('id','desc')
                    ->paginate($listing_count);
        $bundle=['users'=>$users];            
        if(Request()->ajax()){
            return response()->json(view('Admin.usersTable',$bundle)->render());
        }
        return view('Admin.users',$bundle);
    }
    public function editProfile(Request $request){
        $user=Auth::user();
        return view('editProfile',['user'=>$user]);
    }
    public function changePwd(Request $request){
        return view('changePassword');
    }
    public function updatePwd(Request $request){
        $success="error";
        $message="";
        $validator = Validator::make($request->all(), [
            'old_password'=>'required',
            'password'=>'required',
            'conf_password'=>'required|same:password'
        ]);
        if($validator->fails()){
            return  back()->withErrors($validator)->withInput();
        }else{
            $user=Auth::user();
            if ((Hash::check($request->old_password, Auth::user()->password))) {
                $password=Hash::make($request->password);
                $user->password=$password;     
                $user->save();
                $success="success";
                $message="Password updated successfully!";
            }else{
                $success="error";
                $message="incorrect Old password !!";
            }
            return redirect()->back()->with($success,$message);
        }
    }
    public function dashboard(Request $request){
        return view('dashboard');
    }
    public function userLoginForm(Request $request){
        return view('login');
    }
    public function userSignupForm(Request $request){
        return view('register');
    }

    public function makeLogin(Request $request){
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'email'=>'required|email',
        ]);
        if ($validator->fails()) {
            return  back()
                    ->withErrors($validator)
                    ->withInput();
        }

        if(!$this->validateUser($request)){
            return back()->withErrors(['message'=>'invalid email or password!']);
        }else{
            $userData=Auth::user();
            if($userData->status=='active'){
                return redirect()->route('user.dashboard');
            }else if($userData->status!='active'){
                $this->makeLogout();
                return back()->withErrors(['message'=>'Your account is block by Admin, please contact with customer support']);
            }
        }
        
    }
    public function makeSignup(Request $request){
        $user_id=null;
        $message="unable to Signup User, Something went wrong!";
        $validator = Validator::make($request->all(), [
            'email'=>'required|email|unique:users,email',  
            'password'=>'min:6|required',
            'fname'=>'required',
            'lname'=>'required',  
            'phone'=>'required',  
            'mobile'=>'required' , 
            'account_type'=>'required',
            //'g-recaptcha-response' => 'required|captcha',  
            'g-recaptcha-response' => 'required',  
        ]);
        if ($validator->fails()) {
            return  back()
                    ->withErrors($validator)
                    ->withInput();
        }
        $inputs=$request->all();
        $captcha=$inputs['g-recaptcha-response'];
        if($captcha){   
            $secretKey = config('services.nocaptcha_secret');
            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $post_data=[
                'secret'=>$secretKey,
                'response'=>$captcha,
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            //echo $payload = json_encode($post_data);
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
            $response=curl_exec($ch);
            curl_close($ch);
            
            $responseKeys=json_decode($response,true);
            if($responseKeys["success"]){
                $insert_data=array();
                $account_type=$request->account_type;
                $insert_data=[
                    'password'=>Hash::make($request->password),
                    'email'=>$request->email,
                    'fname'=>$request->fname,
                    'lname'=>$request->lname,
                    'phone'=>$request->phone,
                    'mobile'=>$request->mobile,
                    'account_type'=>$account_type,
                    'status'=>"block",
                ];
                if($account_type=="business"){
                    $insert_data['company_name']=$request->company_name;
                    $insert_data['company_address']=$request->company_address;
                    $insert_data['company_phone']=$request->company_phone;
                    $insert_data['website']=$request->website;
                    $insert_data['business_type']=$request->business_type;
                    $insert_data['reg_no']=$request->reg_no;
                    $insert_data['contact_name']=$request->contact_name;
                    $insert_data['contact_position']=$request->contact_position;
                }
                $user=User::updateOrCreate(['id'=>$user_id],$insert_data);
                if($user){
                    try{
                        Mail::to($this->adminEmail)->send(new AdminNotify($user));
                    }catch(Exception $e){
                        echo $e;
                    }
                    $message="User Signup successfully !";
                }
                return redirect()->route('user.loginForm')->with('success',$message);
            }else{
                print_r($responseKeys);
            }
        }
    }
    public function updateProfile(Request $request){
        $user=Auth::user();
        $user_id=$user->id;
        $message="unable to update User, Something went wrong!";
        $validator = Validator::make($request->all(), [
            'email'=>'required|email|unique:users,email,'.$user_id,
            'fname'=>'required',
            'lname'=>'required',  
            'phone'=>'required',  
            'mobile'=>'required', 
            'account_type'=>'required',  
        ]);
        if ($validator->fails()) {
            return  back()
                    ->withErrors($validator)
                    ->withInput();
        }
        $insert_data=array();
        $account_type=$request->account_type;
        $insert_data=[
            'email'=>$request->email,
            'fname'=>$request->fname,
            'lname'=>$request->lname,
            'phone'=>$request->phone,
            'mobile'=>$request->mobile,
            'account_type'=>$account_type,
        ];
        if($account_type=="business"){
            $insert_data['company_name']=$request->company_name;
            $insert_data['company_address']=$request->company_address;
            $insert_data['company_phone']=$request->company_phone;
            $insert_data['website']=$request->website;
            $insert_data['business_type']=$request->business_type;
            $insert_data['reg_no']=$request->reg_no;
            $insert_data['contact_name']=$request->contact_name;
            $insert_data['contact_position']=$request->contact_position;
        }
        $user=User::where(['id'=>$user_id])->update($insert_data);
        if($user){
            $message="User updated successfully !";
        }
        return redirect()->route('user.editProfile')->with('success',$message);
    }

    public function logout(Request $request){
        $this->makeLogout();
        return redirect()->route('user.loginForm');
    }
    public function makeLogout(){
        Auth::guard('web')->logout();
    }
   
    public function validateUser(Request $request){
        if (!Auth::guard('web')->attempt(['email'=>$request->email,'password'=>$request->password])) {
            return false;
        }
        return true;
    }
}
