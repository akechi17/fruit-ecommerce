<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function login(Request $request){
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $credentials = request(['email', 'password']);

        if (auth()->attempt($credentials)){
            $token = Auth::guard('api')->attempt($credentials);
            return response()->json([
                'success' => true,
                'message' => 'login successful',
                'token' => $token
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'email or password is incorrect'
        ]);
}

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function register_customer_action(Request $request){
        $validator = Validator::make($request->all(),[
            'nama_customer' => 'required',
            'no_hp' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'password' => 'required|same:konfirmasi_password',
            'konfirmasi_password' => 'required|same:password'
        ]);

        if ($validator->fails()) {
           Session::flash('errors', $validator->errors()->toArray());
           return redirect('/register_customer');
        }

        $input = $request->all();
        $input['password'] = Hash::make($request->password);
        unset($input['konfirmasi_password']);
        Customer::create($input);
        Session::flash('success', 'Account successfully registered');
        return redirect('/login_customer');
    }

    public function login_customer(){
        return view('auth.login_customer');
    }

    public function login_customer_action(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            Session::flash('errors_login', $validator->errors()->toArray());
            return redirect('/login_customer');
         }

        $credentials = $request->only('email', 'password');
        $customer = Customer::where('email', $request->email)->first();
        if ($customer){
            if(Auth::guard('webcustomer')->attempt($credentials)){
                $request->session()->regenerate();
                return redirect("/");
            } else {
                Session::flash('failed', "Wrong password");
                return redirect('/login_customer');
            }
        } else {
            Session::flash('failed', "Email not found");
            return redirect('/login_customer');
        }
    }

    public function register_customer(){
        return view('auth.register_customer');
    }

    public function logout(){
        Session::flush();
        return redirect('/login');
    }

    public function logout_customer(){
        Auth::guard('webcustomer')->logout();
        Session::flush();
        return redirect('/');
    }
}
