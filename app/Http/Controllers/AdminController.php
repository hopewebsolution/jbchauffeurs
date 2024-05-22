<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\Admin; 
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller{
    public function __construct(){
        
    }
    public function adminChangePwd(Request $request){
        return view('Admin.changePassword');
    }
    public function updateAdminPwd(Request $request){
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
            $admin=Auth::user();
            if ((Hash::check($request->old_password, Auth::user()->password))) {
                $password=Hash::make($request->password);
                $admin->password=$password;     
                $admin->save();
                $success="success";
                $message="Password updated successfully!";
            }else{
                $success="error";
                $message="incorrect Old password !!";
            }
            return redirect()->back()->withInput()->with($success,$message);
        }
    }
    public function forgetPassword(Request $request){
        return view('Admin.forgetPassword');
    }
    public function loginAdmin(){
        return view('Admin.login');
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
        }
        return redirect()->route('admin.dashboard');
    }
    public function logout(){
        $this->makeLogout();
        return redirect()->route('admin.login_form');
    }
    public function makeLogout(){
        Auth::guard('admin')->logout();
    }
    public function validateUser(Request $request){
        if (!Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return false;
        }
        return true;
    }
    public function dashboard(Request $request){
        $redirect_uri=$request->redirect_uri;
        if($redirect_uri){
            return redirect()->route($redirect_uri);
        }
        return view('Admin.dashboard');
    }
}
