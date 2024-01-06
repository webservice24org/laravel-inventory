<?php

namespace App\Http\Controllers;

use App\Mail\inventoryMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    //Register New User
    function userRegistration(Request $request){
        try{
            $request->validate([
                'firstName' => 'required|string|max:50',
                'lastName' => 'required|string|max:50',
                'email' => 'required|string|max:70|unique:users,email',
                'mobile' => 'required|string|max:14|unique:users,mobile',
                'password' => 'required|string|min:8'
            ]);

            User::create([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'password' => Hash::make($request->input('password'))
            ]);

            return response()->json([
                'status'=>'success',
                'message'=>'Your Registration Success!'
            ],200);
        }catch(Exception $e){
            return response()->json([
                'status' => 'Fail',
                'message'=> $e->getMessage()
            ],200);
        }
    }

    function UserLogin(Request $request){
        try {
            $request->validate([
                'email' => 'required|string|max:70',
                'password' => 'required|string|min:8'
            ]); 

            $user = User::where('email', $request->input('email'))->first();

            if(!$user || !Hash::check($request->input('password'), $user->password)){
                return response()->json([
                    'status'=>'Fail', 'message'=> 'User Email or Password is Invalid'],200);  
            }

            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json(['status'=>'success', 'message'=>'User Loggin Success', 'token'=>$token],200);
            
        } catch (Exception $e) {
            return response()->json(['tatus'=>'Fail','message'=> $e->getMessage()],200);
        }
    }

    function UserProfile(Request $request){
        return Auth::User();
    }

    function UserLogout(Request $request){
        $request->user()->tokens()->delete();
        return redirect('/login');
    }

    function userProfileUpdate(Request $request){
        try{
            $request->validate([
                'firstName' => 'required|string|max:50',
                'lastName' => 'required|string|max:50',
                'mobile' => 'required|string|max:14|unique:users,mobile'
            ]);

            User::where('id','=',Auth::id())->update([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'mobile' => $request->input('mobile')
            ]);

            return response()->json([
                'status'=>'success',
                'message'=>'Profile Update Success!'
            ],200);
        }catch(Exception $e){
            return response()->json([
                'status' => 'Fail',
                'message'=> $e->getMessage()
            ],200);
        }
    }

    //send otp
    function sendOtpCode(Request $request){
        try{
            $request->validate([
                'email' => 'required|string|max:70'
            ]); 
            $email = $request->input('email');
            $otp = rand(1000,9999);
            $count = User::where('email','=',$email)->count();

            if ($count==1) {
                Mail::to($email)->send(new inventoryMail($otp));
                User::where('email','=',$email)->update(['otp'=>$otp]);
                return response()->json(['status'=>'success', 'message'=>'4 digit otp sent to your mail!'],200);
            }else{
                return response()->json(['status'=>'Fail', 'message'=>'Invalid Email Address'],200);
            }

        }catch(Exception $e){
            return response()->json(['status'=>'Fail', 'message'=>$e->getMessage()],200);
        }
    }

    //verify otop

    function VerifyOtp(Request $request){
        try{
            $request->validate([
                'email' => 'required|string|max:70',
                'otp' => 'required|string|min:4'
            ]); 
            $email = $request->input('email');
            $otp = $request->input('otp');

            $user = User::where('email','=',$email)->where('otp','=',$otp)->first();

            if (!$user) {
                return response()->json(['status'=>'fail', 'message'=>'Invalid Otp']);
            }

            User::where('email','=',$email)->update(['otp'=>'0']);
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json(['status'=>'success', 'message'=>'Otp Verification Success', 'token'=>$token],200);

        }catch(Exception $e){
            return response()->json(['status'=>'Fail', 'message'=>$e->getMessage()],200);
        }
    }

    //Reset Password
    function resetPassword(Request $request){
        try {
            $request->validate([
                'password'=>'required|string|min:8'
            ]);
            $id=Auth::id();
            $password=$request->input('password');
            User::where('id','=',$id)->update(['password'=>Hash::make($password)]);
            return response()->json(['status'=>'success', 'message'=>'Password Updated Successfully'] );
        } catch (Exception $e) {
            return response()->json(['status'=>'Fail', 'message'=>'Password Reset Faild! try Again']);
        }
    }
}
